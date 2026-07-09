<?php
/**
 * add_4t-skore-heparinom-indukovana-trombocytopenia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): 4T skóre pri podozrení na
 * heparínom indukovanú trombocytopéniu so zameraním na nefrológiu a dialýzu.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_4t-skore-heparinom-indukovana-trombocytopenia_article.php"
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
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => '4T skóre pri podozrení na heparínom indukovanú trombocytopéniu: jednoduchý nástroj s veľkým klinickým významom',
    'slug'         => '4t-skore-heparinom-indukovana-trombocytopenia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => '4T skóre pomáha odhadnúť predtestovú pravdepodobnosť HIT. V nefrologickej a dialyzačnej praxi je cenné najmä tým, že nízke skóre HIT spoľahlivo vylučuje.',
    'content'      => <<<'HTML'
<p>Heparínom indukovaná trombocytopénia (<strong>HIT</strong>) patrí medzi diagnózy, ktoré nemožno podceniť. Môže viesť k život ohrozujúcim trombózam, ale jej zbytočné nadhodnotenie je tiež škodlivé: vedie k prerušeniu heparínu, podaniu alternatívnej antikoagulácie, vyššiemu riziku krvácania, rastu nákladov a diagnostickej neistote.</p>

<p>Práve preto má v praxi veľký význam <strong>4T skóre</strong> – jednoduchý klinický nástroj na odhad predtestovej pravdepodobnosti HIT. Jeho najväčšia sila nie je v tom, že by samo potvrdilo diagnózu, ale v tom, že pri nízkom výsledku HIT veľmi spoľahlivo vylučuje a chráni pacienta pred zbytočnou liečbou.</p>

<h2>Čo je heparínom indukovaná trombocytopénia</h2>

<p>Klinicky závažná HIT je imunitne sprostredkovaná nežiaduca reakcia na heparín. Najčastejšie ide o protilátky proti komplexu <strong>doštičkový faktor 4 (PF4) – heparín</strong>. Tieto protilátky môžu aktivovať trombocyty, monocyty aj endotel, čím vzniká výrazne protrombotický stav.</p>

<p>Typické je, že pacient nemá iba pokles počtu trombocytov. Paradoxom HIT je, že pri trombocytopénii dominuje riziko trombózy, nie krvácania. Môže ísť o hlbokú žilovú trombózu, pľúcnu embóliu, trombózu cievneho prístupu, ischémiu končatiny, cievnu mozgovú príhodu, infarkt myokardu alebo inú arteriálnu či venóznu trombotickú komplikáciu.</p>

<h2>Prečo je HIT dôležitá v nefrológii a dialýze</h2>

<p>Nefrologickí pacienti patria medzi skupiny, v ktorých sa s heparínom stretávame často. Používa sa pri hemodialýze, hospitalizáciách, prevencii tromboembolizmu, liečbe trombóz, invazívnych výkonoch aj pri práci s cievnymi prístupmi.</p>

<p>Podozrenie na HIT môže vzniknúť najmä u pacienta:</p>

<ul>
  <li>na chronickej hemodialýze,</li>
  <li>po zavedení alebo trombóze cievneho prístupu,</li>
  <li>po operácii alebo invazívnom výkone,</li>
  <li>po nedávnej hospitalizácii s profylaktickým heparínom,</li>
  <li>pri poklese trombocytov počas liečby nefrakcionovaným alebo nízkomolekulovým heparínom,</li>
  <li>pri novej trombóze napriek antikoagulačnej liečbe,</li>
  <li>pri opakovanom zrážaní mimotelového dialyzačného okruhu bez zjavnej technickej príčiny.</li>
</ul>

<p>U dialyzovaného pacienta je však diferenciálna diagnostika trombocytopénie široká. Zahŕňa infekciu, sepsu, lieky, hypersplenizmus, krvácanie, diseminovanú intravaskulárnu koaguláciu, pseudotrombocytopéniu, poruchy kostnej drene, autoimunitné ochorenia, mechanickú spotrebu trombocytov a samotný mimotelový obeh. Štruktúrované hodnotenie pomocou 4T skóre preto pomáha zabrániť obom chybám: prehliadnutiu skutočnej HIT aj jej nadmernej diagnostike.</p>

<h2>Štyri zložky 4T skóre</h2>

<p>4T skóre hodnotí štyri klinické oblasti. Každá sa boduje 0, 1 alebo 2 bodmi. Celkový výsledok sa pohybuje od 0 do 8 bodov.</p>

<p>Nasledujúca tabuľka slúži ako praktická orientačná pomôcka. V konkrétnej situácii treba jednotlivé položky hodnotiť podľa celého klinického kontextu, nie iba podľa jedného laboratórneho čísla.</p>

<table>
  <thead>
    <tr>
      <th>Zložka</th>
      <th>2 body</th>
      <th>1 bod</th>
      <th>0 bodov</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><strong>Thrombocytopenia</strong><br>pokles trombocytov</td>
      <td>Pokles &gt; 50 % a nadir približne ≥ 20 × 10<sup>9</sup>/l.</td>
      <td>Pokles 30–50 % alebo nadir 10–19 × 10<sup>9</sup>/l.</td>
      <td>Pokles &lt; 30 % alebo nadir &lt; 10 × 10<sup>9</sup>/l.</td>
    </tr>
    <tr>
      <td><strong>Timing</strong><br>časová súvislosť</td>
      <td>Jasný začiatok typicky 5.–10. deň po expozícii heparínu alebo rýchly pokles po expozícii v posledných 30 dňoch.</td>
      <td>Časovanie je možné, ale menej typické: nejasný začiatok, pokles po 10. dni alebo rýchly pokles po staršej expozícii.</td>
      <td>Pokles trombocytov bez časovej súvislosti s heparínom.</td>
    </tr>
    <tr>
      <td><strong>Thrombosis</strong><br>trombóza alebo následky HIT</td>
      <td>Nová potvrdená trombóza, kožná nekróza po heparíne alebo akútna systémová reakcia po intravenóznom podaní heparínu.</td>
      <td>Progresia alebo recidíva trombózy, podozrenie na trombózu alebo erytematózna kožná reakcia.</td>
      <td>Bez trombózy alebo iného typického následku HIT.</td>
    </tr>
    <tr>
      <td><strong>oTher causes</strong><br>iné príčiny trombocytopénie</td>
      <td>Iná príčina nie je zrejmá.</td>
      <td>Iná príčina je možná.</td>
      <td>Iná príčina je pravdepodobná alebo jasná.</td>
    </tr>
  </tbody>
</table>

<h2>Pokles trombocytov: nestačí pozerať absolútne číslo</h2>

<p>Pri HIT je dôležitá najmä relatívna zmena. Pacient môže mať pokles z 300 na 140 × 10<sup>9</sup>/l. Absolútna hodnota 140 × 10<sup>9</sup>/l môže pôsobiť iba ako mierna trombocytopénia, ale pokles o viac ako polovicu je klinicky významný a do 4T skóre vstupuje ako silný signál.</p>

<p>Naopak, veľmi hlboká trombocytopénia s hodnotami pod 10 × 10<sup>9</sup>/l nie je pre klasickú HIT typická a má viesť k hľadaniu iných príčin, napríklad sepsy, diseminovanej intravaskulárnej koagulácie, liekovej toxicity, imunitnej trombocytopénie alebo hematologického ochorenia.</p>

<h2>Časovanie: rozhoduje anamnéza heparínu</h2>

<p>Klasická HIT sa objavuje najčastejšie medzi 5. až 10. dňom po začatí heparínu. Pri predchádzajúcej expozícii v posledných týždňoch môže vzniknúť rýchlejšie, niekedy už v priebehu 24 hodín. V praxi je preto nevyhnutné zistiť nielen aktuálne podanie heparínu, ale aj nedávnu hospitalizáciu, operáciu, dialýzu, preplach katétra alebo profylaktickú antikoaguláciu.</p>

<p>Ak časová súvislosť nesedí, pravdepodobnosť HIT klesá. Práve tento bod často odlíši skutočné podozrenie od situácie, v ktorej je trombocytopénia iba náhodne prítomná u pacienta, ktorý niekedy dostal heparín.</p>

<h2>Trombóza: pri HIT je krvácanie menší problém než zrážanie</h2>

<p>HIT treba silne zvažovať, ak sa objaví nová trombóza, kožná nekróza v mieste aplikácie heparínu alebo akútna systémová reakcia po intravenóznom podaní heparínu. U nefrologického pacienta môže byť podozrivá aj náhla trombóza dialyzačného prístupu alebo opakované zrážanie mimotelového okruhu.</p>

<p>Tieto situácie však nie sú samy osebe dôkazom HIT. Dialyzačný prístup môže trombotizovať pre stenózu, nízky prietok, zápal, technický problém alebo celkový protrombotický stav pacienta. 4T skóre je užitočné práve preto, že trombotickú udalosť zasadí do širšieho kontextu poklesu trombocytov, časovania a alternatívnych diagnóz.</p>

<h2>Iné príčiny: najklinickejšia časť skóre</h2>

<p>Štvrté „T“ je často najnáročnejšie. Ak existuje jasná iná príčina trombocytopénie, pravdepodobnosť HIT významne klesá. Ak iná príčina nie je zrejmá, podozrenie rastie.</p>

<p>Medzi časté alternatívne príčiny patria sepsa, veľký chirurgický výkon, lieky, diseminovaná intravaskulárna koagulácia, krvácanie, masívna transfúzia, cirhóza, hypersplenizmus, hematologické ochorenie alebo laboratórny artefakt. Pri nečakanom náleze je užitočné overiť aj pseudotrombocytopéniu, napríklad opakovaním odberu do citrátu a kontrolou náteru periférnej krvi.</p>

<h2>Interpretácia výsledku</h2>

<p>Celkové skóre sa interpretuje takto:</p>

<ul>
  <li><strong>0–3 body:</strong> nízka pravdepodobnosť HIT,</li>
  <li><strong>4–5 bodov:</strong> stredná pravdepodobnosť HIT,</li>
  <li><strong>6–8 bodov:</strong> vysoká pravdepodobnosť HIT.</li>
</ul>

<p>Najväčšia sila 4T skóre spočíva v jeho <strong>negatívnej prediktívnej hodnote</strong>. Nízke skóre HIT spravidla veľmi účinne vylučuje. To je klinicky dôležité, pretože znižuje počet zbytočných laboratórnych testov a obmedzuje nevhodné nasadenie alternatívnych antikoagulancií.</p>

<p>Pri strednom alebo vysokom skóre už HIT nemožno bezpečne vylúčiť iba klinicky. Vtedy treba prerušiť heparín, zvoliť vhodnú neheparínovú antikoaguláciu podľa trombotického a krvácavého rizika a doplniť laboratórnu diagnostiku.</p>

<h2>Laboratórna diagnostika</h2>

<p>Laboratórne testovanie HIT má dve hlavné skupiny.</p>

<p>Prvou sú <strong>imunologické testy</strong>, ktoré zachytávajú protilátky proti komplexu PF4–heparín. Sú citlivé, ale pozitívny výsledok nemusí automaticky dokazovať klinicky významnú aktiváciu trombocytov. Falošne pozitívne alebo klinicky nevýznamné nálezy sú problém najmä vtedy, ak sa testuje pacient s nízkou predtestovou pravdepodobnosťou.</p>

<p>Druhou skupinou sú <strong>funkčné testy</strong>, ktoré hodnotia schopnosť protilátok aktivovať trombocyty. Sú špecifickejšie, ale menej dostupné a často časovo náročnejšie.</p>

<p>Správna diagnostika preto spája klinickú pravdepodobnosť s laboratórnym výsledkom. Test bez klinického kontextu môže zavádzať – a pri HIT to platí oboma smermi.</p>

<h2>Čo robiť pri strednej alebo vysokej pravdepodobnosti HIT</h2>

<p>Ak má pacient stredné alebo vysoké 4T skóre, treba konať rýchlo a systematicky. Základné kroky sú:</p>

<ul>
  <li>prerušiť všetky zdroje heparínu vrátane heparínových preplachov katétrov,</li>
  <li>nepoužiť nízkomolekulový heparín ako „bezpečnú“ náhradu,</li>
  <li>začať neheparínovú antikoaguláciu, ak nie je kontraindikovaná,</li>
  <li>odoslať laboratórne testy na HIT podľa lokálnej dostupnosti,</li>
  <li>aktívne hľadať trombotické komplikácie,</li>
  <li>zhodnotiť krvácavé riziko, invazívne výkony a potrebu urgentnej dialýzy,</li>
  <li>konzultovať hematológa pri nejasnostiach, vysokom riziku alebo ťažkom priebehu.</li>
</ul>

<p>Výber alternatívnej antikoagulácie závisí od klinickej situácie, renálnej funkcie, hepatálnej funkcie, potreby výkonu, dostupnosti lieku a možnosti monitorovania. U pacientov so zlyhaním obličiek je toto rozhodnutie obzvlášť citlivé, pretože viaceré antikoagulanciá sa eliminujú renálne a môžu kumulovať.</p>

<h2>Špecifiká pri zlyhaní obličiek</h2>

<p>Pri pokročilej CKD a dialýze je manažment HIT zložitejší. Dialýza sama vyžaduje riešenie antikoagulácie mimotelového okruhu a pacient má často súčasne vysoké trombotické aj krvácavé riziko.</p>

<p>Podľa klinickej situácie možno zvažovať:</p>

<ul>
  <li>regionálnu citrátovú antikoaguláciu, ak je technicky dostupná a bezpečná,</li>
  <li>heparín-free dialýzu s častejším preplachovaním fyziologickým roztokom,</li>
  <li>systémovú neheparínovú antikoaguláciu,</li>
  <li>úpravu dialyzačnej stratégie podľa krvácavého a trombotického rizika,</li>
  <li>hematologickú konzultáciu pri potrebe dlhšej antikoagulácie alebo pri nejasnej laboratórnej interpretácii.</li>
</ul>

<p>U pacienta s klinicky významným podozrením na HIT by sa heparín nemal ponechať len preto, že „dialýza ho potrebuje“. Potreba antikoagulácie okruhu sa dá riešiť inak, hoci niekedy organizačne náročnejšie.</p>

<h2>Najčastejšie chyby pri používaní 4T skóre</h2>

<p>V praxi sa opakujú najmä tieto chyby:</p>

<ul>
  <li>hodnotenie iba absolútneho počtu trombocytov bez porovnania s východiskovou hodnotou,</li>
  <li>prehliadnutie predchádzajúcej expozície heparínu,</li>
  <li>automatické testovanie každého pacienta s trombocytopéniou,</li>
  <li>ignorovanie iných pravdepodobných príčin trombocytopénie,</li>
  <li>pokračovanie v heparíne pri strednom alebo vysokom skóre bez jasného dôvodu a plánu,</li>
  <li>diagnóza HIT iba na základe pozitívneho imunologického testu,</li>
  <li>zámenu nízkomolekulového heparínu za bezpečnú alternatívu pri podozrení na HIT.</li>
</ul>

<p>4T skóre je jednoduché, ale vyžaduje presnú klinickú úvahu. Ak sa vyplní mechanicky, môže byť zavádzajúce.</p>

<h2>Praktický význam kalkulačky</h2>

<p>Kalkulačka, ako je <strong>HIT 4T’s Score</strong> na Medscape Reference, môže pomôcť štandardizovať hodnotenie. Jej výhodou je, že lekára núti prejsť všetky štyri kategórie a nehodnotiť HIT iba intuitívne.</p>

<p>Kalkulačka však nenahrádza klinické rozhodovanie. Pri pacientovi s vysokým trombotickým rizikom, pri nejasnej anamnéze heparínu alebo pri viacerých možných príčinách trombocytopénie je potrebné výsledok interpretovať opatrne. V sporných prípadoch má význam konzultácia hematológa a prehodnotenie skóre po doplnení anamnézy, laboratórnych výsledkov a zobrazovacích vyšetrení.</p>

<h2>Záver</h2>

<p>4T skóre je praktický a klinicky užitočný nástroj na odhad predtestovej pravdepodobnosti heparínom indukovanej trombocytopénie. Jeho najväčšia hodnota spočíva v tom, že nízke skóre HIT spoľahlivo vylučuje a pomáha predchádzať zbytočnému testovaniu aj nevhodnej antikoagulačnej liečbe.</p>

<p>Pre nefrologickú a dialyzačnú prax je 4T skóre mimoriadne dôležité, pretože expozícia heparínu je častá a trombocytopénia má mnoho alternatívnych príčin. Pri strednej alebo vysokej pravdepodobnosti treba konať rýchlo: prerušiť heparín, zvoliť vhodnú alternatívnu antikoaguláciu, doplniť laboratórnu diagnostiku a myslieť na trombotické komplikácie.</p>

<p>Správne použité 4T skóre znižuje riziko dvoch klinických omylov: prehliadnutia skutočnej HIT aj zbytočného označenia pacienta za HIT pozitívneho.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape Reference: „HIT 4T’s Score“, klinická kalkulačka. <a href="https://reference.medscape.com/calculator/113/hit-4t-s-score" target="_blank" rel="noopener noreferrer">Medscape Reference</a>.</em></p>

<p><em><strong>Doplňujúce odborné zdroje:</strong> Lo GK, Juhl D, Warkentin TE, Sigouin CS, Eichler P, Greinacher A. Evaluation of pretest clinical score (4 T’s) for the diagnosis of heparin-induced thrombocytopenia in two clinical settings. <em>Journal of Thrombosis and Haemostasis</em>. 2006; DOI: <a href="https://doi.org/10.1111/j.1538-7836.2006.01787.x" target="_blank" rel="noopener noreferrer">10.1111/j.1538-7836.2006.01787.x</a>. Cuker A et al. Predictive value of the 4Ts scoring system for heparin-induced thrombocytopenia: systematic review and meta-analysis. <em>Blood</em>. 2012. Cuker A et al. American Society of Hematology 2018 guidelines for management of venous thromboembolism: heparin-induced thrombocytopenia. <em>Blood Advances</em>. 2018; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6258919/" target="_blank" rel="noopener noreferrer">PMC</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci článok
// (regenerácia). Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt), is_top = VALUES(is_top)"
);

foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title'        => $a['title'],
            'slug'         => $a['slug'],
            'author'       => $a['author'],
            'content'      => $a['content'],
            'excerpt'      => $a['excerpt'],
            'published_at' => $a['published_at'],
            'is_top'       => $a['is_top'],
        ]);
        // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho článku, 0 = bez zmeny.
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            // UPDATE: lastInsertId nemusí vrátiť existujúce id → dohľadaj podľa slug.
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            // Newsletter avízo LEN pri novom článku, nikdy pri regenerácii/update.
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

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
