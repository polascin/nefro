<?php
/**
 * add_renalna-denervacia-rezistentna-hypertenzia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku o renálnej denervácii pri rezistentnej
 * hypertenzii (Medscape InDiscussion).
 * Postup: git add + commit (deploy hook → SFTP) → spustiť cez SSH.
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Renálna denervácia pri rezistentnej hypertenzii: nádejná metóda, ale nie skratka v liečbe',
    'slug'         => 'renalna-denervacia-rezistentna-hypertenzia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d'),
    'is_top'       => 0,
    'excerpt'      => 'Renálna denervácia môže u vybraných pacientov s rezistentnou hypertenziou znížiť systolický tlak o 5–10 mmHg. Nie je však náhradou diagnostiky, režimových opatrení ani farmakoterapie — má byť súčasťou systému, nie skratkou.',
    'content'      => <<<'HTML'
<p>Rezistentná hypertenzia patrí medzi klinicky najrizikovejšie formy vysokého krvného tlaku. Nejde iba o „vyššie čísla“ na tlakomere. Pacienti s rezistentnou hypertenziou majú vyššie riziko infarktu myokardu, cievnej mozgovej príhody, srdcového zlyhávania, chronickej choroby obličiek a predčasnej kardiovaskulárnej mortality.</p>

<p>V posledných rokoch sa do popredia opäť dostáva <strong>renálna denervácia</strong>. Ide o intervenčný postup, ktorého cieľom je znížiť aktivitu sympatických nervových vlákien v okolí renálnych artérií. Tým môže dôjsť k poklesu krvného tlaku. Podľa diskusie odborníkov v podcaste Medscape <em>InDiscussion</em> sa renálna denervácia postupne začleňuje do štruktúrovaného prístupu k liečbe pacientov s rezistentnou alebo nedostatočne kontrolovanou hypertenziou.</p>

<p>Dôležité však je povedať hneď na začiatku: <strong>renálna denervácia nie je náhradou správnej diagnostiky, režimových opatrení ani farmakoterapie</strong>. Má byť doplnkovou možnosťou u starostlivo vybraných pacientov.</p>

<h2>Čo je rezistentná hypertenzia</h2>

<p>Podľa odporúčaní ACC/AHA a ďalších odborných spoločností z roku 2025 možno rezistentnú hypertenziu definovať dvoma spôsobmi.</p>

<p>Ide buď o stav, keď krvný tlak zostáva nad cieľovými hodnotami napriek liečbe <strong>tromi antihypertenzívami s komplementárnym mechanizmom účinku</strong>, pričom sú použité v maximálne tolerovaných dávkach a súčasťou liečby je diuretikum.</p>

<p>Druhou možnosťou je situácia, keď je krvný tlak síce kontrolovaný, ale pacient na to potrebuje <strong>štyri alebo viac antihypertenzív</strong>.</p>

<p>V praxi je však veľmi dôležité odlíšiť skutočnú rezistentnú hypertenziu od zdanlivej rezistencie. Tá môže byť spôsobená nesprávnym meraním tlaku, nízkou adherenciou k liečbe, nevhodne nastavenou farmakoterapiou alebo fenoménom bieleho plášťa.</p>

<h2>Kedy má byť pacient odoslaný k špecialistovi</h2>

<p>Pacient s podozrením na rezistentnú hypertenziu by nemal čakať roky, kým sa jeho stav „nejako vyvinie“. Odoslanie k špecialistovi na hypertenziu je vhodné najmä vtedy, keď krvný tlak zostáva nekontrolovaný napriek racionálnej úprave liečby, keď je podozrenie na sekundárnu hypertenziu, pri intolerancii viacerých liekov alebo pri známkach poškodenia cieľových orgánov.</p>

<p>Medzi situácie, ktoré majú urýchliť špecializované vyšetrenie, patria najmä:</p>

<ul>
  <li>hypertrofia ľavej komory,</li>
  <li>chronická choroba obličiek,</li>
  <li>diabetes mellitus,</li>
  <li>prekonaná cievna mozgová príhoda,</li>
  <li>významná albuminúria,</li>
  <li>periférne artériové ochorenie,</li>
  <li>iné známky vysokého kardiovaskulárneho rizika.</li>
</ul>

<p>Pri týchto pacientoch môže mať význam aj relatívne malý pokles krvného tlaku. Zníženie systolického tlaku o 5 až 10 mmHg nemusí vyzerať dramaticky, ale u vysokorizikového pacienta môže znamenať významné zníženie rizika závažných kardiovaskulárnych príhod.</p>

<h2>Pred renálnou denerváciou musí prísť dôkladné vyšetrenie</h2>

<p>Renálna denervácia nemá byť reflexným ďalším krokom po zistení vysokého tlaku. Pred jej zvažovaním je potrebné potvrdiť, že ide o skutočnú rezistentnú hypertenziu.</p>

<p>Súčasťou vyšetrenia má byť:</p>

<ul>
  <li>kontrola správnej techniky merania krvného tlaku,</li>
  <li>domáce alebo ambulantné monitorovanie krvného tlaku,</li>
  <li>posúdenie adherencie k liečbe,</li>
  <li>optimalizácia antihypertenzív,</li>
  <li>overenie dostatočného použitia diuretika,</li>
  <li>vylúčenie sekundárnych príčin hypertenzie,</li>
  <li>zhodnotenie režimových faktorov.</li>
</ul>

<p>Medzi sekundárne príčiny, na ktoré treba myslieť, patria najmä primárny aldosteronizmus, stenóza renálnej artérie, chronická choroba obličiek, obštrukčné spánkové apnoe a endokrinné ochorenia.</p>

<p>Až keď sú tieto kroky splnené a krvný tlak zostáva nedostatočne kontrolovaný, má zmysel otvoriť diskusiu o renálnej denervácii.</p>

<h2>Ako sa vyberá vhodný kandidát</h2>

<p>Výber pacienta na renálnu denerváciu má prebiehať v multidisciplinárnom tíme. Ideálne sa na ňom podieľa špecialista na hypertenziu, nefrológ, endokrinológ podľa potreby a intervenčný špecialista, ktorý výkon vykonáva.</p>

<p>Intervenčný lekár musí zhodnotiť najmä anatomické a klinické predpoklady výkonu. Dôležité je vylúčiť významné zúženie renálnych artérií pri ateroskleróze, fibromuskulárnu dyspláziu, významné aneuryzmy renálnych artérií alebo nedávne zavedenie stentu do renálnej artérie.</p>

<p>Významná je aj funkcia obličiek. Neexistuje jednoznačná hranica glomerulovej filtrácie, pod ktorou by bola renálna denervácia absolútne kontraindikovaná. Treba však pripomenúť, že klinické štúdie zahŕňali len málo pacientov s eGFR približne pod 40 ml/min/1,73 m². Pri pokročilej chronickej chorobe obličiek je preto potrebná zvýšená opatrnosť.</p>

<h2>Ako výkon prebieha</h2>

<p>Renálna denervácia sa v súčasnosti najčastejšie vykonáva katetrizačne cez spoločnú femorálnu artériu. Po zavedení katétra sa zobrazia renálne artérie a prípadné akcesórne renálne artérie. Následne sa do artérie zavedie vodič a cez katéter sa aplikuje energia, najčastejšie rádiofrekvenčná alebo ultrazvuková.</p>

<p>Cieľom je poškodiť sympatické nervové vlákna v okolí renálnych artérií, ktoré sa podieľajú na regulácii krvného tlaku.</p>

<p>Výkon trvá približne do jednej hodiny. Pacient je zvyčajne sedovaný tak, aby samotnú abláciu nevnímal bolestivo. Účinok sa však nemusí prejaviť okamžite. U niektorých pacientov sa krvný tlak znižuje postupne počas mesiacov.</p>

<h2>Čo možno od výkonu očakávať</h2>

<p>Pacient musí byť pred výkonom realisticky informovaný. Renálna denervácia nie je „vyliečenie hypertenzie“ a väčšina pacientov bude pokračovať v antihypertenzívnej liečbe.</p>

<p>Priemerný očakávaný pokles krvného tlaku býva skôr mierny. Často sa hovorí o poklese systolického tlaku približne o 5 až 10 mmHg. Klinický význam takého poklesu však netreba podceňovať, najmä u pacientov s vysokým kardiovaskulárnym rizikom.</p>

<p>Treba tiež počítať s tým, že časť pacientov na výkon neodpovie dostatočne. Podľa odborníkov môže ísť približne o tretinu pacientov, v závislosti od použitej definície odpovede a od konkrétnych štúdií.</p>

<p>Za potenciálnu neodpoveď sa zvyčajne neuvažuje bezprostredne po výkone. Hodnotenie efektu má zmysel po niekoľkých mesiacoch, často po 3 až 6 mesiacoch. Niektorí odborníci odporúčajú definitívne hodnotenie až po roku, pretože efekt sa môže rozvíjať postupne.</p>

<h2>Bezpečnosť renálnej denervácie</h2>

<p>Doterajšie randomizované štúdie a registre s dlhodobým sledovaním ukazujú, že renálna denervácia má pri správnej indikácii a skúsenom tíme nízku mieru komplikácií.</p>

<p>Možné komplikácie súvisia najmä s arteriálnym prístupom. Patrí sem krvácanie, hematóm alebo iné komplikácie v mieste vpichu. Keďže ide o femorálny arteriálny prístup, riziko krvácania je vyššie než pri venóznom prístupe, ale pri súčasných technikách zostáva nízke.</p>

<p>Riziko poškodenia renálnej artérie, napríklad disekcie alebo perforácie, je podľa dostupných údajov veľmi nízke. Rovnako zriedkavá je postprocedurálna stenóza renálnej artérie, uvádzaná približne pod 0,2 %.</p>

<p>Dôležité je aj sledovanie funkcie obličiek. Podľa dostupných údajov sa po renálnej denervácii nepozoruje nadmerné zhoršovanie obličkových funkcií nad rámec toho, čo by bolo očakávané u pacientov s hypertenziou a prípadnou chronickou chorobou obličiek.</p>

<h2>Sledovanie po výkone</h2>

<p>Po renálnej denervácii je potrebné pravidelné sledovanie. V klinických štúdiách sa pacienti hodnotili približne po 1 mesiaci, 3 mesiacoch, 6 mesiacoch, po roku a následne každoročne.</p>

<p>V praxi je dôležitá skorá kontrola miesta vpichu, posúdenie bolesti, hematómu a možných lokálnych komplikácií. Následne sa sleduje krvný tlak, renálne funkcie, laboratórne parametre a potreba úpravy liečby.</p>

<p>Približne po 6 mesiacoch sa môže zvážiť zobrazovacie vyšetrenie renálnych artérií, najčastejšie duplexná sonografia. Pri nejasnom náleze možno doplniť CT angiografiu alebo MR angiografiu podľa lokálnych možností a klinickej situácie.</p>

<p>Veľmi dôležité je, aby úprava antihypertenzív neprebiehala chaoticky. Pacienta často sleduje viacero lekárov, napríklad všeobecný lekár, nefrológ, kardiológ, špecialista na hypertenziu a intervenčný lekár. Preto má existovať jasný plán, kto liečbu riadi a ako sa má postupovať pri poklese alebo opätovnom vzostupe krvného tlaku.</p>

<h2>Budúcnosť renálnej denervácie</h2>

<p>Renálna denervácia sa ďalej vyvíja. V Spojených štátoch sú podľa diskusie odborníkov schválené dve zariadenia na zníženie krvného tlaku ako doplnková liečba u pacientov, u ktorých boli použité režimové opatrenia a antihypertenzívna liečba, no tlak zostáva nedostatočne kontrolovaný.</p>

<p>Skúmajú sa aj ďalšie technológie, vrátane nových ultrazvukových systémov, aplikácie alkoholu do steny renálnej artérie, kombinovanej denervácie viacerých orgánov a extravaskulárnych prístupov. Niektoré skoré dáta sú zaujímavé, ale nejde zatiaľ o rutinnú klinickú prax.</p>

<p>Okrem hypertenzie sa skúma aj možný význam renálnej denervácie v iných oblastiach, napríklad pri fibrilácii predsiení. Predbežné údaje naznačujú, že kombinácia ablácie fibrilácie predsiení s renálnou denerváciou môže u niektorých pacientov znížiť riziko recidívy arytmie. Aj tu však platí, že definitívne miesto tejto stratégie v praxi si vyžaduje ďalšie dôkazy.</p>

<h2>Praktický záver</h2>

<p>Renálna denervácia je zaujímavá a perspektívna metóda v liečbe rezistentnej a nedostatočne kontrolovanej hypertenzie. Jej prínos spočíva najmä v tom, že aj mierny, ale dlhodobo udržaný pokles krvného tlaku môže u vysokorizikových pacientov významne znížiť kardiovaskulárne riziko.</p>

<p>Nie je to však výkon pre každého pacienta s hypertenziou. Pred jej zvažovaním je potrebné potvrdiť skutočnú rezistenciu, vylúčiť sekundárne príčiny, optimalizovať liečbu a zabezpečiť dlhodobé sledovanie.</p>

<p>Najdôležitejšie posolstvo je jednoduché: <strong>renálna denervácia má byť súčasťou systému, nie náhradou systému</strong>. Najväčší úžitok môže priniesť vtedy, keď je indikovaná uvážene, vykonaná skúseným tímom a zaradená do koordinovanej, multidisciplinárnej starostlivosti o pacienta s vysokým kardiovaskulárnym rizikom.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, „Renal Denervation and Resistant Hypertension“. <a href="https://www.medscape.com/viewarticle/1003189" target="_blank" rel="noopener noreferrer">medscape.com</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author), content = VALUES(content),
        excerpt = VALUES(excerpt), is_top = VALUES(is_top), is_published = VALUES(is_published),
        updated_at = NOW()"
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

        // Newsletter avízo LEN pri prvom vložení, nikdy pri regenerácii/update.
        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
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
    echo "Migrácia článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted z $total článkov bolo vložených.\n";
    echo "Preskočení (slug už existuje): $skipped\n";
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

          <div class="alert <?= $inserted > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> z <?= $total ?> článkov bolo vložených. <?= $skipped ?> preskočených (slug už existuje).</p>
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
