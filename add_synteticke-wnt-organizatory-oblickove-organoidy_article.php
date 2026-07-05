<?php
/**
 * add_synteticke-wnt-organizatory-oblickove-organoidy_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): syntetické Wnt-sekretujúce
 * organizátory, priestorové vzorovanie ľudských obličkových organoidov
 * a význam pre nefrologický výskum.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_synteticke-wnt-organizatory-oblickove-organoidy_article.php"
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
    'title'        => 'Syntetické Wnt-sekretujúce organizátory zlepšujú priestorové usporiadanie ľudských obličkových organoidov',
    'slug'         => 'synteticke-wnt-organizatory-oblickove-organoidy',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Štúdia v Science ukazuje, že lokálne WNT signály zo syntetických bunkových organizátorov dokážu lepšie usporiadať ľudské obličkové organoidy a zvýšiť ich výpovednú hodnotu pre nefrologický výskum.',
    'content'      => <<<'HTML'
<p>Obličkový organoid nie je len zhluk „správnych“ buniek. Aby bol biologicky a experimentálne použiteľný, bunky sa musia objaviť aj v správnej polohe, v správnej orientácii a v správnom vzťahu k susedným štruktúram. Práve priestorové vzorovanie zostáva jednou z hlavných slabín súčasných obličkových organoidov odvodených z ľudských pluripotentných kmeňových buniek.</p>

<p>Nová práca publikovaná v časopise <em>Science</em> ukazuje, že túto slabinu možno cielene ovplyvniť. Autori využili synteticky navrhnuté bunky, ktoré fungujú ako lokálny zdroj WNT signálu, a zaviedli ich do ľudských obličkových organoidov. Výsledkom bolo organizovanejšie usporiadanie vyvíjajúcich sa nefrónových štruktúr, najmä lepšia orientácia morfogenézy smerom k zdroju signálu a podpora distálnej nefrónovej diferenciácie.</p>

<p>Z pohľadu nefrológie nejde o bezprostredný terapeutický prelom ani o vytvorenie funkčnej obličky v laboratóriu. Ide však o dôležitý experimentálny krok: vývojovú geometriu obličkového tkaniva možno nielen pozorovať, ale aj racionálne rekonštruovať.</p>

<h2>Prečo pri organoidoch nestačí bunková diferenciácia</h2>

<p>Obličkové organoidy sú významným modelom pre výskum nefrogenézy, vrodených nefropatií, tubulárnych ochorení, nefrotoxicity a perspektívne aj personalizovaných modelov chorôb. Súčasné protokoly dokážu vytvoriť viaceré nefrónové komponenty, ale výsledné štruktúry sú často priestorovo variabilné. Segmenty nefrónu môžu byť prítomné, no nemusia byť usporiadané spôsobom, ktorý verne napodobňuje embryonálnu obličku.</p>

<p>V prirodzenom vývoji obličky vzniká tkanivo v presnom priestorovom dialógu medzi ureterovým pupeňom, zberacím systémom a nefrogénnym mezenchýmom. Bunky nereagujú iba na to, či je signál prítomný alebo neprítomný. Reagujú aj na jeho lokálnu koncentráciu, smer, trvanie a polohu voči ostatným tkanivovým štruktúram. Preto môže rovnaký signál pôsobiť odlišne, ak je podaný difúzne do celého kultivačného média alebo ak vzniká ako lokálne signálne pole v presne určenej oblasti organoidu.</p>

<p>Toto rozlíšenie je pre interpretáciu organoidových modelov zásadné. Model, ktorý obsahuje podocyty, tubulárne bunky a ďalšie nefrónové prvky, ešte nemusí spoľahlivo napodobňovať orgánovú biológiu, ak chýba anatomická nadväznosť a smerová organizácia.</p>

<h2>Hranica WNT11–WNT9B ako vývojová navigácia</h2>

<p>Autori použili priestorovú transkriptomiku ľudského vývoja obličky a identifikovali organizačný vzorec, podľa ktorého sa vznikajúce nefróny orientujú voči zberaciemu systému. Kľúčovým nálezom bola polarita od oblasti susediacej so zberacím duktom smerom k vzdialenejším častiam nefrónu.</p>

<p>Táto os sa nachádza pri signálnej hranici medzi <em>WNT11</em> a <em>WNT9B</em>. Zjednodušene povedané, nejde iba o prítomnosť WNT signálnej dráhy, ale o jej priestorové usporiadanie na rozhraní zberacieho systému a vyvíjajúceho sa nefrónu. Práve takáto hranica môže určovať, kde sa aktivujú distálne programy nefrónovej diferenciácie a ktorým smerom sa vyvíjajúca tubulárna štruktúra predlžuje.</p>

<p>Pre klinicky uvažujúceho nefrológa je dôležité najmä to, že segmentová identita nefrónu a jeho priestorová orientácia nie sú oddelené javy. Funkčný význam proximálneho tubulu, Henleho kľučky, distálneho tubulu, zberacieho systému a glomerulárnej zložky závisí od ich vzájomnej nadväznosti. Organoid s lepšou geometriou preto môže byť spoľahlivejším modelom než organoid, ktorý má síce správne bunkové markery, ale chaotickú architektúru.</p>

<h2>Syntetické organizátory ako lokálny zdroj signálu</h2>

<p>Vývojové organizátory sú bunkové alebo tkanivové oblasti, ktoré vytvárajú morfogenetické signálne pole a tým usmerňujú osud aj tvar susedných buniek. V tejto práci autori využili syntetické Wnt-sekretujúce bunkové organizátory. Ich úlohou nebolo vytvoriť vlastné obličkové tkanivo, ale pôsobiť ako lokalizovaný zdroj signálu, ktorý dáva organoidu priestorovú informáciu.</p>

<p>Po zavedení týchto organizátorov do obličkových organoidov sa pozorovali dva dôležité efekty:</p>

<ul>
  <li><strong>podpora distálnej nefrónovej diferenciácie</strong> – organoidy nadobúdali výraznejšie distálne nefrónové programy, ktoré sú v bežných organoidových protokoloch často slabšie zastúpené,</li>
  <li><strong>orientovaná morfogenéza nefrónov</strong> – nefrónové štruktúry sa nevyvíjali len radiálne alebo náhodne, ale orientovali sa smerom k zdroju WNT signálu.</li>
</ul>

<p>Tento výsledok je dôležitý aj metodologicky. Ukazuje, že samoorganizáciu organoidu netreba úplne nahradiť externým inžinierstvom. Možno ju skôr usmerniť tým, že sa do systému doplní chýbajúca lokálna vývojová informácia.</p>

<h2>Význam pre nefrologický výskum</h2>

<p>Lepšie organizované obličkové organoidy môžu zvýšiť hodnotu modelov, ktoré sa používajú na štúdium vývoja obličiek a ochorení s tubulárnou alebo segmentovou zložkou. Najväčší potenciál je tam, kde nestačí sledovať iba expresiu jednotlivých markerov, ale kde záleží aj na polohe, polarite a nadväznosti buniek v tkanive.</p>

<p>Prakticky môže ísť najmä o tieto oblasti:</p>

<ul>
  <li>výskum kongenitálnych anomálií obličiek a močových ciest,</li>
  <li>modelovanie porúch nefrogenézy a segmentácie nefrónu,</li>
  <li>štúdium dedičných tubulopatií a ciliopatií,</li>
  <li>testovanie nefrotoxicity liekov v modeloch s lepšou architektúrou,</li>
  <li>porovnávanie organoidov odvodených z indukovaných pluripotentných kmeňových buniek konkrétneho pacienta,</li>
  <li>dlhodobý vývoj regeneratívnych stratégií, kde bude nevyhnutná nielen bunková skladba, ale aj orgánová organizácia.</li>
</ul>

<p>Zároveň treba povedať, že organoidy s lepším vzorovaním môžu zlepšiť reprodukovateľnosť experimentov. Pri modeloch, ktoré vznikajú samoorganizáciou, je variabilita medzi organoidmi zásadným limitom. Ak sa podarí tkanivové usporiadanie riadiť predvídateľnejšie, výsledky môžu byť robustnejšie a lepšie porovnateľné medzi laboratóriami.</p>

<h2>Čo štúdia neznamená</h2>

<p>Výsledky netreba interpretovať ako dôkaz, že už vieme vytvoriť transplantovateľnú ľudskú obličku. Organoidy stále nemajú plnohodnotnú vaskularizáciu, kompletný zberací a odtokový systém, architektúru dospelého orgánu ani fyziologickú funkciu porovnateľnú s natívnou obličkou. Chýba im aj integrované prepojenie s hemodynamikou, imunitným prostredím a systémovou reguláciou, ktoré sú pre skutočnú obličku rozhodujúce.</p>

<p>Rovnako nejde o postup, ktorý by mal okamžitý dopad na liečbu chronickej choroby obličiek, diabetickej choroby obličiek, glomerulonefritíd alebo polycystickej choroby obličiek. Klinická hodnota tejto práce je zatiaľ nepriamym príspevkom k lepším experimentálnym modelom.</p>

<p>Práve táto opatrnosť je však súčasťou jej významu. Štúdia nerieši všetky limity organoidov, ale veľmi presne adresuje jeden z najdôležitejších: nedostatočné priestorové usporiadanie.</p>

<h2>Klinický nefrologický pohľad</h2>

<p>Pre praktického nefrológa je najdôležitejšie posolstvo jednoduché: kvalita experimentálneho modelu obličky sa nebude dať hodnotiť len podľa toho, či obsahuje „správne“ bunkové typy. Rovnako dôležité bude, či tieto bunky tvoria správne tkanivové vzťahy.</p>

<p>Ak majú organoidy slúžiť ako modely chorôb, predikcia toxicity alebo platformy pre individualizovanú medicínu, musia sa viac priblížiť reálnej vývojovej a funkčnej architektúre obličky. Lokálne syntetické organizátory predstavujú jeden zo spôsobov, ako sa k tomu priblížiť bez toho, aby sa stratila prirodzená schopnosť buniek samoorganizovať sa.</p>

<p>Z nefrologického hľadiska preto táto práca nie je správou o „hotovej umelej obličke“, ale o presnejšom ovládaní vývojových pravidiel, podľa ktorých obličkové tkanivo vzniká. To môže byť v budúcnosti dôležité pre výskum vrodených nefropatií, personalizované modelovanie ochorení aj vývoj spoľahlivejších preklinických testov.</p>

<h2>Záver</h2>

<p>Práca Fausta a kolegov ukazuje, že syntetické Wnt-sekretujúce organizátory dokážu v ľudských obličkových organoidoch rekonštruovať časť vývojovej signálnej geometrie. Identifikácia osi súvisiacej s hranicou <em>WNT11</em>–<em>WNT9B</em> a jej následné napodobnenie pomocou lokálneho WNT zdroja posúva organoidové modely od samotnej bunkovej diferenciácie k riadenejšiemu tkanivovému usporiadaniu.</p>

<p>Pre klinickú prax je dopad zatiaľ vzdialený. Pre nefrologický výskum je však tento koncept významný: ak chceme modelovať obličku vernejšie, musíme modelovať nielen bunkové typy, ale aj priestorové pravidlá, ktoré z nich vytvárajú orgán.</p>

<hr>

<p><em><strong>Zdroj:</strong> Fausto CC, Glykofrydis F, Kumar N, Schnell J, Csipan RL, De Kuyper F, Kunnan M, Grubbs B, Thornton M, Thompson M, Chang E, Wen X, Pelayo M, Achieng M, Seth A, Street K, Morsut L, Lindström NO. Patterning human kidney organoids with synthetic Wnt-secreting organizers. <em>Science</em>. 2026;393(6806). doi:10.1126/science.adu9122. <a href="https://www.science.org/doi/10.1126/science.adu9122" target="_blank" rel="noopener noreferrer">Science.org</a>.</em></p>
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
                error_log('add_synteticke_wnt newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_synteticke_wnt pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_synteticke_wnt pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_synteticke_wnt migration error: ' . $e->getMessage());
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
