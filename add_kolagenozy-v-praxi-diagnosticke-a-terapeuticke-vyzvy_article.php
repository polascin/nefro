<?php
/**
 * add_TEMPLATE_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * ŠABLÓNA pre vkladanie nového článku.
 * Postup:
 *   1. Skopíruj tento súbor ako  add_<slug>_article.php
 *   2. Vyplň všetky sekcie označené  ← VYPLNIŤ
 *   3. git add + git commit  →  deploy hook automaticky nahrá súbor na server
 *   4. Spusti cez SSH:
 *      ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *          uid58858@shell.r1.websupport.sk \
 *          "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_<slug>_article.php"
 * ════════════════════════════════════════════════════════════════════════════
 *
 * PRAVIDLÁ PRE OBSAH:
 *   • title    – čistý text, bez HTML; zobrazí sa ako <h1> na stránke článku
 *   • slug     – len [a-z0-9-], max 80 znakov; musí byť unikátny v DB
 *                Diakritika → ASCII: á→a, č→c, š→s, ž→z, ľ→l, ô→o, ú→u …
 *   • excerpt  – 1–2 vety (max ~300 znakov), čistý text; zobrazuje sa v zozname
 *   • content  – HTML; NESMIE začínať <h2> zhodným s titulom (duplikát)
 *                Nadpisy sekcií → <h2>…</h2>
 *                Zoznam        → <ul>/<ol> + <li>
 *                Tučné         → <strong>, kurzíva → <em>
 *                Externé linky → <a href="…" target="_blank" rel="noopener noreferrer">
 *                Záver (zdroj) → <hr><p><em>Zdroj: …</em></p>
 *   • is_top   – 0 = bežný článok, 1 = odporúčaný (zobrazí sa vo featured sekcii)
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
    'title'        => 'Kolagenózy v praxi: diagnostické a terapeutické výzvy pri systémových autoimunitných ochoreniach',
    'slug'         => 'kolagenozy-v-praxi-diagnosticke-a-terapeuticke-vyzvy',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kolagenózy sú systémové autoimunitné ochorenia s rôznorodými prejavmi. Orgánovo orientovaný prístup k diagnostike (moč, svaly, autoprotilátky) aj k bezpečnej terapii – ako včas zachytiť orgánové ohrozenie a liečiť podľa rizika.',
    'content'      => <<<'HTML'
<p>Streamed Up v sérii <strong>RheumaLive</strong> venovanej téme <strong>„Kollagenosen 2026“</strong> zdôrazňuje, že ide o skupinu chorôb s výrazne odlišnými klinickými prejavmi a s diagnostickými aj terapeutickými rozhodnutiami, ktoré musia reflektovať postihnutie orgánov a individuálnu dynamiku ochorenia. V tomto článku to rozoberám „klinicky“: ako pristupovať k podozreniu na kolagenózu, ako rýchlo zachytiť orgánové ohrozenie a ako rozumne nastaviť liečbu tak, aby zodpovedala riziku.</p>

<h2>1) Čo sú kolagenózy a prečo sú „ťažké“</h2>

<p>Kolagenózy sú <strong>systémové autoimunitné ochorenia</strong>, pri ktorých imunitný systém postihuje viaceré orgánové systémy naraz alebo sa postihnutie vyvíja postupne. To je aj dôvod, prečo sa diagnóza často odkladá: symptómy môžu byť na prvý pohľad nesúvisiace (napríklad koža, kĺby, pľúca, obličky, svaly, nervový systém).</p>

<p>Aj pri moderných imunologických metódach platí, že:</p>
<ul>
  <li>prezentácia môže byť nešpecifická alebo „prekrývajúca sa“ (overlap),</li>
  <li>biologická aktivita sa nemusí dokonale zhodovať so subjektívnymi ťažkosťami pacienta,</li>
  <li>a orgánové komplikácie môžu nastúpiť rýchlo.</li>
</ul>

<p>Práve preto je dôležité uvažovať systémovo už od prvého kontaktu a nastaviť si diagnostický plán, ktorý včas pokrýva „najhoršie scenáre“.</p>

<h2>2) Prvý krok: klinická mapa rizík</h2>

<p>V praxi je užitočné rozdeliť anamnézu a vyšetrenie do troch hlavných oblastí:</p>

<h3>A) Systémové symptómy a zápalová aktivita</h3>

<p>Horúčky, chudnutie, únava, artralgie a laboratórne známky zápalu (CRP, sedimentácia) sú len „vodítko“. Samy osebe diagnózu neurčia, ale hovoria, že nejde o izolovaný problém.</p>

<h3>B) Orgánové varovné príznaky</h3>

<p>Pri kolagenózach môže byť rozhodujúce, či už ide o ohrozenie orgánu. Typické príklady:</p>
<ul>
  <li><strong>obličky</strong> (napríklad proteinúria, opuchy, penivosť moču, zhoršenie renálnych parametrov),</li>
  <li><strong>svaly</strong> (progredujúca svalová slabosť),</li>
  <li><strong>pľúca</strong> (dyspnoe, kašeľ, intersticiálne zmeny, iné respiračné prejavy),</li>
  <li>a často aj <strong>koža a sliznice</strong> (exantém, fotosenzitivita, ulcerácie).</li>
</ul>

<p>Povedané jednoducho: diagnostika kolagenóz nie je len o „správnom názve“, ale predovšetkým o tom, či pacienta treba chrániť pred orgánovým poškodením práve teraz.</p>

<h3>C) Vzorec príznakov („pattern“) podľa domén</h3>

<p>Ak sa príznaky opakujú v typických zostavách, zvyšuje sa pravdepodobnosť určitej podskupiny kolagenózy. Napríklad pri svalovej slabosti treba cielene myslieť na myozitídové spektrum.</p>

<h2>3) Diagnostika: čo sa robí a prečo nestačí jeden test</h2>

<p>Rheuma-Liga uvádza praktický a na orgány orientovaný diagnostický postup: lekár najprv zhodnotí typické symptómy, doplní laboratóriá a zobrazovanie (napríklad ultrazvuk, RTG), sleduje funkcie postihnutých orgánov a v niektorých situáciách sa pristúpi aj k mikroskopickému vyšetreniu tkaniva (napríklad k biopsii). Dôležité je, že symptómy sa medzi jednotlivými kolagenózami líšia a často si vyžadujú individualizovaný plán.</p>

<h3>3.1 Laboratóriá a imunológia: protilátky ako „smerovník“</h3>

<p>Autoprotilátky môžu diagnózu významne urýchliť. Rheuma-Liga spomína, že <strong>antinukleárne protilátky (ANA)</strong> sú pri kolagenózach často prítomné a bližšie určenie typu protilátok môže pomôcť rozlíšiť podskupiny. Pri niektorých entitách sa cielene vyšetrujú aj špecifické autoprotilátky (napríklad anti-dsDNA pri aktívnom SLE, prípadne anti-Ro a anti-La pri Sjögrenovom syndróme).</p>

<p>Kľúčové praktické ponaučenie:</p>
<ul>
  <li>protilátky sú výborný nástroj, ale <strong>nie sú náhradou kliniky</strong>,</li>
  <li>a pozitívny nález bez zodpovedajúceho fenotypu vyžaduje opatrnosť, aby sa pacient zbytočne „neoznačil“.</li>
</ul>

<h3>3.2 Moč a obličkové ukazovatele pri podozrení na nefritídu</h3>

<p>Pri podozrení na postihnutie obličiek sa uplatňuje vyšetrenie moču a následné hodnotenie príznakov glomerulárneho poškodenia. Rheuma-Liga uvádza, že zápal pri systémovom lupus erythematosus možno zachytiť vyšetrením moču a prvými viditeľnými varovaniami môžu byť opuchy členkov a pena v moči ako signál vysokého obsahu bielkovín.</p>

<h3>3.3 Svaly: klinika plus enzýmy a zobrazenie, niekedy aj EMG a biopsia</h3>

<p>Ak dominuje svalová slabosť, Rheuma-Liga spomína, že typické sú zvýšené svalové enzýmy; doplniť ich môže ultrazvuk, MRI, elektromyografia a v prípade potreby aj biopsia svalu. Tento prístup je logický: svalová slabosť má viac príčin a kolagenózové myozitídy treba odlíšiť od infekčných, toxických či iných etiológií.</p>

<h2>4) V čom je terapeutická výzva: liečiť rýchlo, ale nie naslepo</h2>

<p>Streamed Up v popise podujatia uvádza, že sa riešia „diagnostické a terapeutické výzvy“ pri rôznych formách kolagenóz. Aj bez podrobného záznamu jednotlivých prednášok sa dá medicínsky rozumne zhrnúť, čo tieto výzvy typicky znamenajú:</p>

<ol>
  <li><strong>Rýchlosť rozhodnutia.</strong> Pri orgánovo ohrozujúcich formách nie je priestor na dlhé diagnostické váhanie. Ak sú jasné známky aktivity a rizika, terapia sa zvyčajne začína podľa závažnosti, pričom diagnóza sa priebežne spresňuje.</li>
  <li><strong>Vyváženie účinnosti a bezpečnosti.</strong> Imunosupresia môže dramaticky zlepšiť prognózu, ale zvyšuje riziko infekcií, metabolických komplikácií a nežiaducich účinkov. Preto treba vopred myslieť na prevenciu a monitorovanie.</li>
  <li><strong>Stratifikácia podľa orgánového postihnutia.</strong> Nie je to jedna liečba pre všetkých. Taktika sa mení podľa toho, či ide o kožné, kĺbové, pľúcne alebo obličkové postihnutie.</li>
  <li><strong>Dlhodobé riadenie.</strong> Cieľom nie je iba krátkodobá remisia, ale aj jej udržanie bez relapsu a minimalizácia kumulatívnej toxicity liečby.</li>
</ol>

<h2>5) Praktický diagnosticko-terapeutický rámec (čo by mal vedieť klinik)</h2>

<p>Nasledujúci rámec je praktický a „aplikovateľný“; nie je to presný algoritmus jedného konkrétneho programu.</p>

<h3>Krok 1: Potvrdiť, že nejde o jednorazový incident</h3>

<p>Zhodnoťte trend príznakov, zápalové parametre a to, či existujú „orgánové“ príznaky. Ak dominuje napríklad nefritída alebo myozitída, nejde o asymptomatický nález.</p>

<h3>Krok 2: Cieliť diagnostiku na orgány</h3>

<p>Zámer: odhaliť postihnutie obličiek, svalov, pľúc a iných systémov tak, aby liečba nebola zbytočne oneskorená a aby bola adekvátna riziku. V praxi to typicky znamená:</p>
<ul>
  <li>vyšetrenie moču pri podozrení na nefritídu,</li>
  <li>svalové enzýmy, zobrazovanie a doplnenie podľa potreby pri slabosti,</li>
  <li>a ďalšie cielené vyšetrenia podľa kliniky.</li>
</ul>

<h3>Krok 3: Imunologická stratifikácia</h3>

<p>Použite ANA a doplnkové protilátky na orientáciu, pričom výsledok vždy interpretujte v kontexte pacienta.</p>

<h3>Krok 4: Multidisciplinárne rozhodnutie</h3>

<p>Pri aktívnom orgánovom postihnutí je často potrebná spolupráca reumatológa, nefrológa, pneumológa alebo neurológa podľa domény. Tým sa skracuje cesta k správnej intervencii.</p>

<h2>6) Čo s „nejasnými“ prípadmi</h2>

<p>Keď je klinika rozporuplná a protilátky sú hraničné alebo nešpecifické, je to typická situácia, v ktorej sa ľahko urobí diagnostická chyba v oboch smeroch:</p>
<ul>
  <li>buď sa významná aktivita podcení,</li>
  <li>alebo sa pacient zbytočne lieči, hoci ide o inú príčinu.</li>
</ul>

<p>V takých prípadoch rozhoduje:</p>
<ul>
  <li>časový priebeh,</li>
  <li>kvalita monitorovania (opakované hodnotenie orgánov),</li>
  <li>a zrozumiteľný plán, čo je ďalší krok, ak sa aktivita zhorší.</li>
</ul>

<h2>7) Záver</h2>

<p>Kolagenózy sú skupina systémových autoimunitných ochorení, pri ktorých nerozhoduje jediné laboratórne vyšetrenie, ale premyslený, orgánovo orientovaný prístup. Podujatie „Kollagenosen 2026“ v rámci RheumaLive poukazuje na to, že v tejto oblasti existujú významné diagnostické aj terapeutické výzvy. Klinicky sa to prejavuje potrebou rýchlo zachytiť orgánové ohrozenie, správne interpretovať imunologické nálezy a liečbu prispôsobiť riziku a dynamike ochorenia. Praktický rámec z diagnostiky (moč, svaly, autoprotilátky, doplnenie podľa domény) a z bezpečnej terapie je základ, aby sme pacienta ochránili pred poškodením orgánov a zároveň minimalizovali liečebnú záťaž.</p>

<hr>

<p><em><strong>Zdroj (podujatie):</strong> streamed-up.com, „Kollagenosen 2026“ (RheumaLive, 2026). <a href="https://streamed-up.com/live/kollagenosen-2026" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>

<p><em><strong>Zdroj (klinický prehľad diagnostiky kolagenóz):</strong> Rheuma-Liga, „Kollagenosen“. <a href="https://www.rheuma-liga.de/rheuma/krankheitsbilder/kollagenosen" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
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
