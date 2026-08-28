<?php
/**
 * add_kontrola-draslika-ckd-edukovat-nie-strasit_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_kontrola-draslika-ckd-edukovat-nie-strasit_article.php"
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
    'title'        => 'Kontrola draslíka pri ochorení obličiek: edukovať, nie strašiť',
    'slug'         => 'kontrola-draslika-ckd-edukovat-nie-strasit',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Hyperkaliémia pri pokročilom ochorení obličiek je vážny problém, no moderný prístup nestavia na strašení zoznamom zakázaných potravín. Kľúčom je individuálna edukácia, práca s veľkosťou porcie, správna úprava jedla a riešenie zápchy.',
    'content'      => <<<'HTML'
<p>Hyperkaliémia môže byť pri pokročilom ochorení obličiek vážnym a rýchlo sa rozvíjajúcim problémom. To však neznamená, že každého pacienta treba automaticky vystrašiť dlhým zoznamom zakázaných potravín. Práve naopak. Moderný prístup k diétnym odporúčaniam pri chronickom ochorení obličiek a dialýze by mal byť individuálny, praktický a zrozumiteľný.</p>

<p>Starší spôsob edukácie často stál na jednoduchom odkaze: nejedzte banány, nepite pomarančový džús, vyhýbajte sa zemiakom, strukovinám a ďalším potravinám s vyšším obsahom draslíka. Takýto prístup síce vychádzal zo snahy predísť hyperkaliémii, no u mnohých pacientov vyvolával strach, rezignáciu alebo zbytočné obmedzenia. Pacient, ktorý sa bojí jedla, často lepšie nespolupracuje. Skôr sa stratí v zákazoch.</p>

<p>Cieľom nie je draslík ignorovať. Cieľom je naučiť pacienta, ako s ním rozumne pracovať.</p>

<h2>Nie všetko musí byť zakázané</h2>

<p>Pri zlyhávaní obličiek môže byť hladina draslíka zvýšená najmä preto, že obličky už nedokážu draslík dostatočne vylučovať. U pacienta pred začatím dialýzy alebo krátko po ňom môže byť situácia iná ako u stabilizovaného pacienta na pravidelnej dialyzačnej liečbe.</p>

<p>Preto nie je rozumné vytvárať jeden univerzálny zoznam zakázaných potravín pre všetkých. Pacient potrebuje odporúčania podľa aktuálnej hladiny draslíka, typu liečby, reziduálnej diurézy, dialyzačnej dávky, liekov, výživového stavu, prítomnosti zápchy a celkového klinického kontextu.</p>

<p>Jednoduché zákazy môžu byť praktické v akútnej situácii, ale z dlhodobého hľadiska často nestačia.</p>

<h2>Varenie a vylúhovanie pomáha znížiť obsah draslíka</h2>

<p>Jedným z praktických postupov je úprava potravín s vyšším obsahom draslíka. Typickým príkladom sú zemiaky.</p>

<p>Pri ošúpaní, nakrájaní na menšie kúsky a varení vo väčšom množstve vody sa časť draslíka dostáva do vody. Samotné namáčanie má len obmedzený efekt, ale nakrájanie alebo nastrúhanie a následné varenie môže obsah draslíka výrazne znížiť. Podľa citovaného zdroja môže pri vhodnej úprave dôjsť k zníženiu obsahu draslíka približne o 50 až 75 %.</p>

<p>Praktické odporúčanie pre pacienta môže znieť:</p>

<ul>
  <li>zemiaky ošúpať,</li>
  <li>nakrájať na kocky,</li>
  <li>variť vo veľkom množstve vody,</li>
  <li>vodu po približne 10 minútach zliať,</li>
  <li>doliať čistú vodu a dovariť.</li>
</ul>

<p>Takto pripravené zemiaky, napríklad ako zemiaková kaša, môžu byť vhodnejšou voľbou než pečené zemiaky. Podobný princíp sa dá využiť aj pri niektorých strukovinách, tekvici či iných potravinách s vyšším obsahom draslíka, hoci výskum je najlepšie doložený najmä pri zemiakoch a podobných hľuzách.</p>

<h2>Porcia je často dôležitejšia než zákaz</h2>

<p>Mnohí pacienti si z edukácie zapamätajú najmä vetu: „Banány nesmiete.“ Alebo: „Pomarančový džús je zakázaný.“ Problém je, že takto formulované odporúčania nevedú pacienta k porozumeniu. Vedú skôr k slepému dodržiavaniu alebo k úplnému odmietnutiu diéty.</p>

<p>Niektoré potraviny, ktoré sa tradične objavovali na zoznamoch zakázaných jedál, nemusia byť pri primeranej porcii problémom. Napríklad jedna šálka melóna alebo zeleného hrozna obsahuje približne 180 mg draslíka, čo je pod bežne používanou hranicou 200 mg na porciu pre potravinu s vysokým obsahom draslíka.</p>

<p>Kľúčom je veľkosť porcie.</p>

<p>Pri ovocí, ktoré sa ľahko zje vo veľkom množstve, môže pomôcť jednoduchý trik: ovocie zamraziť. Mrazené hrozno, kúsky melóna alebo ananásu sa jedia pomalšie, pôsobia osviežujúco a môžu pomôcť obmedziť nekontrolované množstvo. Navyše môžu podporiť pravidelnú stolicu a znížiť potrebu nadmerného príjmu tekutín v horúcom počasí.</p>

<p>Ak má pacient rád ovocie s vyšším obsahom draslíka, napríklad banán, melón alebo kantalup, praktickým riešením môže byť ovocný šalát. Doň sa pridá polovičná porcia ovocia s vyšším obsahom draslíka a doplní sa ovocím s nižším obsahom draslíka, napríklad čučoriedkami, jahodami, černicami alebo ananásom. Pacient tak získa väčší objem jedla bez neprimeraného zvýšenia príjmu draslíka.</p>

<h2>Zápcha môže zhoršovať kontrolu draslíka</h2>

<p>Pri chronickom ochorení obličiek sa často zhoršuje zápcha. Prispievajú k tomu obmedzenia tekutín, nižší príjem vlákniny, znížená pohybová aktivita a viaceré lieky.</p>

<p>Z pohľadu draslíka je dôležité, že pri poklese renálneho vylučovania sa črevo môže podieľať na kompenzačnom vylučovaní draslíka. Ak je však pasáž spomalená, vstrebávanie draslíka v čreve môže byť vyššie a tento kompenzačný mechanizmus nemusí byť dostatočne účinný.</p>

<p>Preto má liečba zápchy u pacienta s ochorením obličiek aj metabolický význam.</p>

<p>Praktické opatrenia môžu zahŕňať:</p>

<ul>
  <li>primeranú úpravu príjmu tekutín podľa klinického stavu,</li>
  <li>výber potravín s vlákninou a nižším obsahom draslíka,</li>
  <li>zaradenie vhodných druhov ovocia, napríklad černíc,</li>
  <li>zváženie vhodných laxatív po dohode s ošetrujúcim tímom,</li>
  <li>pravidelnú fyzickú aktivitu podľa možností pacienta,</li>
  <li>edukáciu o správnej polohe pri vyprázdňovaní.</li>
</ul>

<p>Nie je vhodné riešiť hyperkaliémiu iba škrtaním potravín, ak má pacient súčasne výraznú zápchu, nízky príjem vlákniny a zlú kvalitu života.</p>

<h2>Edukácia má byť individuálna</h2>

<p>Pacient s ochorením obličiek už často čelí mnohým obmedzeniam. Musí sledovať tekutiny, fosfor, sodík, bielkoviny, lieky, dialyzačný režim, laboratórne výsledky a ďalšie odporúčania. Ak k tomu dostane ešte neprehľadný zoznam „zakázaných“ potravín bez vysvetlenia, výsledkom nemusí byť lepšia adherencia. Môže nastať presný opak.</p>

<p>Lepšia edukácia znamená vysvetliť:</p>

<ul>
  <li>prečo je draslík dôležitý,</li>
  <li>ktoré potraviny sú rizikovejšie,</li>
  <li>ako rozhoduje veľkosť porcie,</li>
  <li>ako môže pomôcť technologická úprava jedla,</li>
  <li>kedy je potrebné byť prísnejší,</li>
  <li>kedy možno diétu opatrne liberalizovať,</li>
  <li>ako súvisia zápcha, lieky a dialýza s hladinou draslíka.</li>
</ul>

<p>Pacient nemá byť pasívnym príjemcom zákazov. Má rozumieť tomu, čo robí a prečo to robí.</p>

<h2>Praktický odkaz pre klinickú prax</h2>

<p>Prístup „radšej všetko zakážme“ je zdanlivo bezpečný, ale nie vždy je najlepší. Môže viesť k strachu z jedla, horšiemu príjmu živín, frustrácii a nízkej spolupráci. Pri stabilizovaných pacientoch je často vhodnejšia cielená edukácia, práca s porciou, úprava prípravy jedla a riešenie pridružených problémov, najmä zápchy.</p>

<p>Samozrejme, pri závažnej alebo opakovanej hyperkaliémii treba postupovať striktnejšie a individuálne. Diétne odporúčania musia rešpektovať laboratórne hodnoty, EKG nález, liečbu, reziduálnu funkciu obličiek, dialyzačný režim a celkový stav pacienta.</p>

<p>Najlepšie odporúčanie nie je také, ktoré pacienta vystraší. Najlepšie odporúčanie je také, ktoré dokáže dlhodobo používať v bežnom živote.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, <em>Potassium Control: How to Educate, Not Scare, Patients With Kidney Disease</em> (2026). <a href="https://www.medscape.com/viewarticle/potassium-control-how-educate-not-scare-patients-kidney-2026a1000idx" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
    echo "Migrácia článku: " . $articles[0]['title'] . "\n";
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
