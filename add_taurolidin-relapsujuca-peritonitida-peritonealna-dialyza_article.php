<?php
/**
 * add_taurolidin-relapsujuca-peritonitida-peritonealna-dialyza_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): adjuvantný taurolidín pri
 * relapsujúcej peritonitíde u pacientov na peritoneálnej dialýze.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_taurolidin-relapsujuca-peritonitida-peritonealna-dialyza_article.php"
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
    'title'        => 'Adjuvantný taurolidín pri relapsujúcej peritonitíde na peritoneálnej dialýze: záchrana katétra alebo slepá ulička?',
    'slug'         => 'taurolidin-relapsujuca-peritonitida-peritonealna-dialyza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Taurolidín môže byť u vybraných pacientov s relapsujúcou PD peritonitídou zaujímavou adjuvantnou stratégiou proti katétrovému biofilmu. Nemá však nahradiť antibiotiká ani odkladať odstránenie katétra, keď je klinicky indikované.',
    'content'      => <<<'HTML'
<p>Peritonitída zostáva jednou z najzávažnejších komplikácií peritoneálnej dialýzy (PD). Nie je to len akútna infekčná epizóda. Opakované, relapsujúce alebo refraktérne peritonitídy zvyšujú riziko poškodenia peritoneálnej membrány, zlyhania techniky, hospitalizácie, prechodu na hemodialýzu a u krehkých pacientov aj celkovej morbidity.</p>

<p>Článok v <em>Journal of Nephrology</em> zo série „Lessons for the clinical nephrologist“ sa venuje použitiu <strong>taurolidínu</strong> ako adjuvantnej stratégie u starostlivo vybraných pacientov s relapsujúcou PD peritonitídou. Ide o prakticky zaujímavú tému, najmä v situáciách, keď štandardná antibiotická liečba opakovane prinesie len dočasné zlepšenie a infekcia sa vracia.</p>

<p>Kľúčové je hneď na začiatku povedať hranicu: taurolidín nie je náhrada štandardnej antibiotickej liečby peritonitídy a nemá slúžiť na odkladanie odstránenia infikovaného katétra, ak je katéter potrebné odstrániť. Je to možná doplnková stratégia v úzkom klinickom okne, kde sa ešte racionálne uvažuje o záchrane PD techniky.</p>

<h2>Prečo je relapsujúca peritonitída taká problematická</h2>

<p>Pri peritoneálnej dialýze je peritoneálna dutina opakovane vystavená manipulácii, pripojeniam a odpojeniam dialyzačného systému. Aj pri dobrej technike zostáva riziko kontaminácie a infekcie prítomné. Väčšina epizód sa dá zvládnuť antibiotickou liečbou, ale relapsujúci priebeh je iná klinická situácia.</p>

<p>Podľa praktického rámca ISPD treba rozlišovať viacero pojmov. <strong>Relapsujúca peritonitída</strong> je návrat peritonitídy do 4 týždňov po ukončení liečby s rovnakým mikroorganizmom alebo s jednou sterilnou kultivačnou epizódou v sekvencii. <strong>Rekurentná peritonitída</strong> sa vracia v podobnom časovom okne, ale s iným mikroorganizmom. <strong>Repeat peritonitis</strong> je návrat s rovnakým mikroorganizmom po viac ako 4 týždňoch od ukončenia liečby. <strong>Refraktérna peritonitída</strong> znamená, že dialyzát sa napriek primeranej antibiotickej liečbe nevyčistí v očakávanom čase, typicky po 5 dňoch.</p>

<p>Tieto rozdiely nie sú akademické. Relaps často naznačuje perzistujúci infekčný fokus: biofilm na katétri, kolonizáciu katétrového tunela, nedostatočnú eradikáciu mikroorganizmu alebo kombináciu viacerých faktorov. Takáto situácia sa už nedá riešiť len automatickým opakovaním rovnakého antibiotického režimu.</p>

<h2>Biofilm ako skrytý rezervoár infekcie</h2>

<p>Jedným z hlavných dôvodov, prečo sa peritonitída môže vracať, je <strong>biofilm</strong> na peritoneálnom katétri. Biofilm je štruktúrovaná mikrobiálna komunita obalená extracelulárnou matrix. Baktérie v biofilme majú zníženú citlivosť na antibiotiká a lepšie prežívajú nepriaznivé podmienky.</p>

<p>Pri PD je katéter dlhodobo zavedené cudzie teleso. Ak sa na ňom vytvorí biofilm, antibiotická liečba môže potlačiť planktonické baktérie v dialyzáte, ale nemusí úplne odstrániť mikroorganizmy ukryté na povrchu katétra. Po ukončení liečby sa infekcia môže znova aktivovať.</p>

<p>Preto sa pri relapsujúcej, rekurentnej alebo opakovanej peritonitíde má včas zvažovať odstránenie katétra. Zachovanie katétra za každú cenu nie je dobrá stratégia, ak rastie riziko závažnej infekcie, poškodenia peritoneálnej membrány alebo zlyhania celej metódy.</p>

<h2>Čo je taurolidín</h2>

<p>Taurolidín je antimikrobiálna látka s účinkom proti baktériám a niektorým hubám. V medicíne sa používal najmä v súvislosti s prevenciou katétrových infekcií, vrátane centrálnych venóznych katétrov. Zaujímavý je najmä jeho účinok na mikroorganizmy v biofilme a nižšia tendencia k vzniku klasickej antimikrobiálnej rezistencie v porovnaní s bežnými antibiotikami.</p>

<p>V kontexte PD sa taurolidín skúma najmä ako <em>lock</em> roztok alebo adjuvantná katétrová intervencia. Cieľom nie je liečiť akútnu peritonitídu namiesto antibiotík, ale znížiť riziko, že katéter zostane rezervoárom mikroorganizmov a že sa infekcia po ukončení liečby znovu objaví.</p>

<h2>Kedy o taurolidíne uvažovať</h2>

<p>O adjuvantnom taurolidíne možno uvažovať najmä vtedy, keď sa stretáva viacero podmienok:</p>

<ul>
  <li>ide o relapsujúcu PD peritonitídu,</li>
  <li>mikrobiologický obraz naznačuje návrat rovnakej infekcie,</li>
  <li>existuje podozrenie na biofilm alebo katétrový rezervoár,</li>
  <li>pacient klinicky odpovedá na antibiotickú liečbu, ale infekcia sa vracia,</li>
  <li>odstránenie katétra je možné, ale predstavuje významnú klinickú alebo logistickú záťaž,</li>
  <li>rozhodnutie sa robí v centre so skúsenosťou s peritoneálnou dialýzou a s jasným plánom ďalšieho postupu.</li>
</ul>

<p>Naopak, pri refraktérnej peritonitíde, ťažkom septickom stave, plesňovej peritonitíde, infekcii s jasným postihnutím tunela alebo pri klinickom zlyhaní konzervatívneho postupu nemožno odkladať odstránenie katétra len preto, že existuje teoretická možnosť adjuvantnej liečby.</p>

<h2>Antibiotiká a ISPD rámec zostávajú základom</h2>

<p>Pri PD peritonitíde je základom rýchla diagnostika a včasné podanie antibiotík. Klinické rozhodnutia majú vychádzať z klinického stavu pacienta, cytológie dialyzátu, Gramovho farbenia, kultivácie a citlivosti, predchádzajúcich epizód peritonitídy, prítomnosti exit-site alebo tunelovej infekcie a lokálnych mikrobiologických dát.</p>

<p>Taurolidín, ak sa použije, je doplnok k štandardnej liečbe. Nemá oddialiť antibiotiká, mikrobiologické vyšetrenie, kontrolu katétra ani rozhodnutie o jeho odstránení. ISPD odporúčania zdôrazňujú, že pri refraktérnej peritonitíde sa má PD katéter odstrániť a pri relapsujúcej, rekurentnej alebo opakovanej peritonitíde sa má včas zvážiť odstránenie katétra alebo jeho výmena.</p>

<h2>Význam pre vzdialené a vidiecke oblasti</h2>

<p>Kľúčové slová zdrojového článku zahŕňajú aj <em>rural and remote health</em>, teda zdravotnú starostlivosť vo vidieckych a vzdialených oblastiach. To je veľmi praktická poznámka. Peritoneálna dialýza má pre pacientov žijúcich ďaleko od dialyzačného centra veľký význam. Umožňuje domácu liečbu a znižuje potrebu pravidelného dochádzania na hemodialýzu.</p>

<p>Ak takýto pacient stratí možnosť PD pre relapsujúcu peritonitídu, môže to znamenať zásadné zhoršenie kvality života aj dostupnosti liečby. V takýchto situáciách môže byť snaha o záchranu techniky klinicky opodstatnená. Musí však byť bezpečná a časovo ohraničená. Cieľom je zachrániť pacienta a metódu, nie slepo zachraňovať katéter.</p>

<h2>Praktický algoritmus pre nefrológa</h2>

<p>Pri relapsujúcej peritonitíde u pacienta na PD je rozumné postupovať systematicky:</p>

<ol>
  <li><strong>Potvrdiť diagnózu relapsu.</strong> Porovnať aktuálny mikrobiologický nález s predchádzajúcou epizódou a zhodnotiť časový odstup.</li>
  <li><strong>Zhodnotiť katéter a tunel.</strong> Hľadať exit-site infekciu, tunelovú infekciu, mechanické komplikácie a známky katétrového rezervoára.</li>
  <li><strong>Skontrolovať techniku výmen.</strong> Opakovaná kontaminácia môže súvisieť s chybou v technike, zhoršeným zrakom, kognitívnym problémom alebo nedostatočnou domácou podporou.</li>
  <li><strong>Nasadiť cielenú antibiotickú liečbu.</strong> Liečba má rešpektovať kultiváciu, citlivosť, predchádzajúce epizódy a odporúčania pre PD peritonitídu.</li>
  <li><strong>Rozhodnúť o záchrane katétra alebo jeho odstránení.</strong> Pri vhodnom pacientovi možno zvážiť adjuvantný postup vrátane taurolidínu. Pri refraktérnom alebo rizikovom priebehu treba katéter odstrániť.</li>
  <li><strong>Naplánovať prevenciu ďalších epizód.</strong> Patrí sem reedukácia pacienta, kontrola zásob a hygienických postupov, liečba exit-site infekcie, úprava podpory doma a audit predchádzajúcich epizód.</li>
</ol>

<h2>Limity dôkazov</h2>

<p>Použitie taurolidínu pri relapsujúcej PD peritonitíde nie je zatiaľ štandardizované na úrovni veľkých randomizovaných štúdií. Dôkazy sú obmedzené a často vychádzajú z kazuistík, menších sérií alebo extrapolácie zo skúseností s katétrovými infekciami.</p>

<p>Aj zdrojový článok má charakter „Lessons for the clinical nephrologist“, teda prakticko-edukačný formát. Nejde o veľkú intervenčnú štúdiu, ktorá by definitívne stanovila účinnosť taurolidínu v tejto indikácii. Preto je namieste opatrnosť v jazyku aj v praxi: taurolidín môže byť možnosťou, nie štandardom pre každého pacienta.</p>

<h2>Klinické posolstvo</h2>

<p>Taurolidín môže byť zaujímavou doplnkovou možnosťou pri starostlivo vybraných pacientoch s relapsujúcou PD peritonitídou, najmä ak je cieľom potlačiť katétrový biofilm a zachovať peritoneálnu dialýzu. Použitie však musí byť individuálne, opatrné a podriadené bezpečnosti pacienta.</p>

<p>Najväčšou chybou by bolo vnímať taurolidín ako spôsob, ako odložiť odstránenie infikovaného katétra v situácii, kde je už odstránenie jasne indikované. Najväčším prínosom môže byť naopak jeho racionálne použitie v úzkom okne medzi opakovaným relapsom a definitívnym zlyhaním techniky.</p>

<h2>Záver</h2>

<p>Relapsujúca peritonitída pri peritoneálnej dialýze je závažný klinický problém, pri ktorom treba myslieť na biofilm, katétrový rezervoár infekcie a riziko zlyhania techniky. Taurolidín predstavuje potenciálnu adjuvantnú možnosť u vybraných pacientov, najmä tam, kde je bezpečné zachovanie PD klinicky významné.</p>

<p>Pre klinickú prax platí jednoduchý záver: taurolidín môže byť užitočný doplnok, ale nie náhrada za včasnú antibiotickú liečbu, dôslednú mikrobiologickú diagnostiku, kontrolu katétra a rozhodnutie o jeho odstránení, ak si to stav pacienta vyžaduje.</p>

<hr>

<p><em><strong>Zdroj:</strong> Rycen J, Santagada S, Srivastava V. Lessons for the clinical nephrologist: adjuvant taurolidine in selected patients with relapsing peritoneal dialysis-related peritonitis. <em>Journal of Nephrology</em>. Publikované online 26. júna 2026; aajag045. doi:10.1093/joneph/aajag045. <a href="https://academic.oup.com/joneph/advance-article/doi/10.1093/joneph/aajag045/8718962" target="_blank" rel="noopener noreferrer">Oxford Academic</a>.</em></p>

<p><em><strong>Doplňujúci rámec:</strong> ISPD peritonitis guideline recommendations: 2022 update on prevention and treatment. <em>Peritoneal Dialysis International</em>. 2022;42(2):110–153. doi:10.1177/08968608221080586.</em></p>
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
                error_log('add_taurolidin_pd_peritonitida newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_taurolidin_pd_peritonitida pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_taurolidin_pd_peritonitida pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_taurolidin_pd_peritonitida migration error: ' . $e->getMessage());
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
