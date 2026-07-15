<?php
/**
 * add_inhibicia-tmao-fmc-regresia-fibrozy-ckd-model_article.php
 * Odborný článok o cielenej inhibícii mikrobiálnej tvorby TMAO v modeli CKD.
 * Pôvodní autori spracovaného zdroja sú uvedení v source_authors.php.
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
    'title'        => 'Cielená inhibícia mikrobiálnej tvorby TMAO v modeli CKD: regresia fibrózy, nie klinický dôkaz',
    'slug'         => 'inhibicia-tmao-fmc-regresia-fibrozy-ckd-model',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Fluorometylcholín v myšom modeli etablovanej CKD potlačil tvorbu TMAO a sprevádzala ho regresia fibrózy. Výsledok je sľubný, zatiaľ však výlučne experimentálny.',
    'content'      => <<<'HTML'
<p>Chronická choroba obličiek (CKD) mení črevný mikrobióm a zároveň znižuje vylučovanie viacerých mikrobiálnych metabolitov. Medzi najviac skúmané patrí trimetylamín-N-oxid (TMAO), ktorého vyššie koncentrácie sa u ľudí spájajú s horšou funkciou obličiek, kardiovaskulárnym rizikom a nepriaznivou prognózou. Samotná asociácia však nerozlišuje, či je TMAO príčinou poškodenia, jeho následkom alebo oboma súčasne.</p>

<p>Experimentálna práca DiDonata a spoluautorov v časopise <em>Journal of the American Society of Nephrology</em> sa preto nepýtala iba na prevenciu CKD. Autori začali cielenú inhibíciu mikrobiálnej tvorby TMAO až po rozvinutí funkčného a histologického poškodenia obličiek. Liečba fluorometylcholínom (FMC) zastavila ďalšiu progresiu a v myšom modeli ju sprevádzala čiastočná regresia tubulointersticiálnej fibrózy.</p>

<p>Základné mechanizmy a klinické asociácie TMAO sú podrobnejšie vysvetlené v samostatnom článku <a href="article.php?slug=tmao-crevny-metabolit-uremicky-toxin-ckd">Trimetylamín-N-oxid pri CKD</a>. Tento text sa sústreďuje na novú intervenčnú štúdiu a na hranice jej interpretácie.</p>

<h2>Os črevo – pečeň – obličky</h2>

<p>Črevné baktérie premieňajú cholín a niektoré ďalšie živinové substráty na trimetylamín (TMA). Po absorpcii sa TMA v pečeni oxiduje, najmä enzýmom flavínovou monooxygenázou 3 (FMO3), na TMAO. TMAO sa následne vylučuje prevažne obličkami, takže jeho koncentrácia prirodzene stúpa pri poklese glomerulovej filtrácie.</p>

<p>FMC je mechanizmom podmienený inhibítor mikrobiálnej cholín-TMA-lyázy. Zasahuje tvorbu TMA v čreve, a tým nepriamo znižuje hepatálnu produkciu TMAO. Nejde o všeobecné antibiotické potlačenie mikrobiómu, ale o zásah do konkrétnej mikrobiálnej metabolickej dráhy. To je podstatné, pretože cieľom nie je sterilizovať črevo, ale obmedziť tvorbu vybraného metabolitu.</p>

<h2>Dvojfázový model etablovanej CKD</h2>

<p>Autori použili myši CD1 a štúdiu rozdelili na dve fázy. V prvej fáze podstúpili zvieratá jednostrannú nefrektómiu alebo simulovaný výkon a počas 12 týždňov dostávali stravu s vysokým obsahom tukov s pridaním 1 % cholínu alebo bez neho. Funkčné, biochemické a histologické merania potvrdili rozvoj CKD pred začatím experimentálnej liečby.</p>

<p>V druhej fáze boli myši po nefrektómii s cholínovou suplementáciou randomizované na pokračovanie pôvodnej diéty s FMC alebo bez FMC počas ďalších ôsmich týždňov. Takéto usporiadanie umožnilo odlíšiť prevenciu vzniku poškodenia od zásahu do už rozvinutého ochorenia.</p>

<div class="table-responsive" role="region" aria-label="Kľúčové výsledky experimentálnej štúdie inhibície TMAO" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Fáza a porovnanie</th>
      <th scope="col">Hlavný výsledok</th>
      <th scope="col">Správna interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Po 12 týždňoch nefrektómie a cholínovej diéty</td>
      <td>Približne 15-násobne vyššie TMAO, pokles meranej GFR o 48 % a 3,5-násobne väčšia tubulointersticiálna fibróza</td>
      <td>Model mal pred liečbou preukázané funkčné aj štruktúrne poškodenie</td>
    </tr>
    <tr>
      <td>Ďalších 8 týždňov bez FMC</td>
      <td>Pokračujúci vzostup TMAO, progresia funkčného poškodenia a fibrózy</td>
      <td>Neliečená skupina dokumentovala prirodzenú progresiu modelu</td>
    </tr>
    <tr>
      <td>Ďalších 8 týždňov s FMC</td>
      <td>Takmer úplné potlačenie cirkulujúceho TMAO, o viac než 50 % vyššia meraná GFR oproti neliečenej skupine, pokles fibrózy o 41 % a vzostup meranej GFR o 39 % oproti stavu pred liečebnou fázou</td>
      <td>Ide o regresiu fenotypu v konkrétnom myšom modeli, nie o klinický účinok u ľudí</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Zlepšila sa funkcia aj histologický obraz</h2>

<p>FMC prakticky eliminoval cirkulujúci TMAO a zlepšil všetky sledované fenotypy CKD. Okrem meranej glomerulovej filtrácie sa znížili koncentrácie kreatinínu, cystatínu C a pseudouridínu, pomer albumínu ku kreatinínu v moči, expresia profibrotických génov a histologické ukazovatele tubulointersticiálnej fibrózy.</p>

<p>Znížili sa aj koncentrácie ďalších retenčných solútov vrátane indoxylsulfátu a fenylacetylglycínu. Tento nález môže znamenať, že zásah do metabolizmu cholínu ovplyvnil širšie črevno-metabolické prostredie. Zároveň však komplikuje jednoduchý záver, že celý účinok bol sprostredkovaný výlučne poklesom TMAO.</p>

<h2>Prečo je regresia fibrózy dôležitá</h2>

<p>Mnohé experimentálne intervencie dokážu spomaliť vznik alebo progresiu poškodenia. Oveľa náročnejšie je preukázať zlepšenie po tom, ako už poklesla funkcia obličiek a vznikla fibróza. V tejto štúdii bolo poškodenie zdokumentované pred randomizáciou do liečebnej fázy, preto výsledok podporuje hypotézu, že mikrobiálna metabolická os nie je iba sprievodným znakom CKD.</p>

<p>Slovo „regresia“ však treba viazať na presne meraný experimentálny fenotyp. Neznamená obnovu normálnej obličky, vyliečenie CKD ani dôkaz, že rovnaký zásah oddiali dialýzu alebo zníži mortalitu u človeka.</p>

<h2>Čo zo štúdie nemožno vyvodiť</h2>

<ul>
  <li><strong>Nejde o klinickú štúdiu.</strong> FMC sa v tejto práci nepodával pacientom a neboli hodnotené klinické renálne ani kardiovaskulárne príhody.</li>
  <li><strong>Model nie je bežná ľudská CKD.</strong> Kombinácia jednostrannej nefrektómie, vysokotukovej diéty a 1 % cholínu vytvára kontrolované experimentálne prostredie, nie heterogénne spektrum diabetickej, glomerulovej či hereditárnej CKD.</li>
  <li><strong>TMAO zatiaľ nie je rutinný terapeutický biomarker.</strong> Koncentráciu ovplyvňuje eGFR, strava, mikrobióm, lieky aj komorbidity a nie je stanovený klinický cieľ, na ktorý by sa mala liečba titrovať.</li>
  <li><strong>Bezpečnosť u ľudí nie je známa.</strong> Treba preveriť dlhodobý vplyv selektívnej inhibície mikrobiálneho enzýmu na mikrobióm, hostiteľský metabolizmus, výživu a nežiaduce účinky.</li>
</ul>

<h2>Čo sa dnes v liečbe CKD nemení</h2>

<p>Výsledok nemení štandardnú nefroprotektívnu liečbu. Základom zostáva určenie etiológie CKD, kontrola krvného tlaku a objemového stavu, blokáda renín-angiotenzínového systému pri príslušnej indikácii, použitie inhibítora SGLT2 podľa eGFR a albuminúrie, liečba diabetu a kardiovaskulárneho rizika, prevencia nefrotoxicity a včasné plánovanie náhrady funkcie obličiek.</p>

<p>U pacientov s diabetom 2. typu a pretrvávajúcou albuminúriou môže pri splnení kritérií patriť do komplexnej liečby aj nesteroidný antagonista mineralokortikoidového receptora s preukázaným kardiorenálnym prínosom. Experimentálna inhibícia TMAO tieto overené piliere nenahrádza.</p>

<h2>Výživa: žiadne extrémne obmedzenie cholínu</h2>

<p>Cholín je esenciálna živina. Z myšieho modelu s 1 % suplementáciou cholínu nemožno odvodiť odporúčanie, aby pacienti s CKD svojvoľne vylúčili vajcia, ryby alebo iné zdroje cholínu. Takýto postup by mohol zhoršiť kvalitu stravy a u krehkých pacientov zvýšiť riziko malnutrície.</p>

<p>Rozumná, prevažne nespracovaná strava a individuálne prispôsobený príjem bielkovín, sodíka, draslíka a fosforu zostávajú vhodným rámcom. Konkrétne reštrikcie majú vychádzať zo štádia CKD, laboratórnych výsledkov, komorbidít a nutričného stavu, nie z izolovanej koncentrácie TMAO.</p>

<h2>Najdôležitejšie limity</h2>

<ul>
  <li>malý zvierací model bez priameho dôkazu účinnosti alebo bezpečnosti u ľudí,</li>
  <li>špecificky indukovaný fenotyp CKD s vysokou cholínovou záťažou,</li>
  <li>osemtýždňová liečebná fáza bez údajov o dlhodobej udržateľnosti účinku,</li>
  <li>možnosť, že časť účinku súvisela so širšími zmenami mikrobiálneho metabolizmu, nie iba s TMAO,</li>
  <li>chýbajúce výsledky relevantné pre pacientov, ako sú zlyhanie obličiek, hospitalizácie, kardiovaskulárne príhody a mortalita.</li>
</ul>

<h2>Záver</h2>

<p>Cielená inhibícia mikrobiálnej tvorby TMAO pomocou FMC po etablovaní CKD viedla v myšom modeli k zastaveniu progresie, zlepšeniu meranej glomerulovej filtrácie a čiastočnej regresii tubulointersticiálnej fibrózy. Dvojfázový dizajn posilňuje biologický argument, že os črevo – pečeň – obličky môže byť terapeuticky ovplyvniteľná aj po vzniku poškodenia.</p>

<p>Pre klinickú prax je však správnym záverom záujem, nie zmena liečby. Pred použitím podobného prístupu u pacientov budú potrebné štúdie farmakokinetiky, bezpečnosti, dávkovania a následne randomizované klinické skúšania s renálnymi a kardiovaskulárnymi výsledkami.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> DiDonato JA, Weeks TL, Gupta N, et al. Targeted Inhibition of Gut-Microbial Trimethylamine N-Oxide Production Fosters Regression of CKD Phenotypes. <em>Journal of the American Society of Nephrology</em>. Publikované online 10. júla 2026. DOI: 10.1681/ASN.0000001171. <a href="https://pubmed.ncbi.nlm.nih.gov/42430743/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1681/ASN.0000001171" target="_blank" rel="noopener noreferrer">DOI</a>.</em></p>

<p><em><strong>Predchádzajúci experimentálny kontext:</strong> Gupta N, Buffa JA, Roberts AB, et al. Targeted Inhibition of Gut Microbial Trimethylamine N-Oxide Production Reduces Renal Tubulointerstitial Fibrosis and Functional Impairment in a Murine Model of Chronic Kidney Disease. <em>Arteriosclerosis, Thrombosis, and Vascular Biology</em>. 2020;40:1239–1255. <a href="https://pubmed.ncbi.nlm.nih.gov/32212854/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<p><em><strong>Klinický kontext:</strong> Kidney Disease: Improving Global Outcomes. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Odporúčania KDIGO</a>.</em></p>
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
                error_log('add_inhibicia_tmao_fmc newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_inhibicia_tmao_fmc pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_inhibicia_tmao_fmc pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_inhibicia_tmao_fmc migration error: ' . $e->getMessage());
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
