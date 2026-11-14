<?php

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Nespavosť a nadmerná denná spavosť pri chronickej chorobe obličiek',
    'slug'         => 'nespavost-denna-spavost-ckd-rein',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Vo francúzskej kohorte CKD-REIN bez dialýzy uvádzalo nespavosť 22 % pacientov a nadmernú dennú spavosť 15 %. Nespavosť sa spájala s kŕčmi a svrbením, denná spavosť najmä s únavou.',
    'content'      => <<<'HTML'
<figure><img src="img/nespavost-denna-spavost-ckd-rein.webp" alt="Človek sedí v noci na okraji postele a hľadí von oknom" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia nočného bdenia vytvorená pomocou umelej inteligencie.</figcaption></figure>

<p>Vo francúzskej kohorte CKD-REIN uvádzalo pri vstupe nespavosť 22 % pacientov s chronickou chorobou obličiek (CKD) bez dialýzy a nadmernú dennú spavosť 15 %. Nespavosť sa spájala najmä s tým, ako veľmi pacientov trápili kŕče, svrbenie a obavy súvisiace s ochorením obličiek. Pri dennej spavosti bola najvýraznejšia súvislosť s únavou [1].</p>

<h2>Ako sa zisťovali poruchy spánku</h2>
<p>Prospektívna kohorta zahŕňala dospelých s CKD v štádiách G2 až G5 zo 40 nefrologických ambulancií vo Francúzsku. Pri zaradení nepodstupovali dialýzu a nemali transplantovanú obličku. Aspoň jeden dotazník vyplnilo 2 765 pacientov. Ich priemerný vek bol 67 rokov, 66 % tvorili muži a priemerná odhadovaná glomerulová filtrácia (eGFR) bola 34 ml/min/1,73 m². Dotazníky pri zaradení a po jednom, troch a piatich rokoch poskytli 7 264 pozorovaní. Autori pri analýze zohľadnili opakované merania u toho istého pacienta [1].</p>
<p>Za nespavosť sa považoval zle hodnotený spánok v predchádzajúcich troch mesiacoch spolu s ťažkosťami so zaspávaním, prebúdzaním počas noci alebo predčasným ranným prebudením bez opätovného zaspania aspoň trikrát týždenne. Pri nadmernej dennej spavosti sa zisťoval pocit výraznej spavosti cez deň aspoň trikrát týždenne v rovnakom období. Vstupná prevalencia dosiahla 22 % (95 % interval spoľahlivosti od 21 do 24 %) pri nespavosti a 15 % (od 14 do 16 %) pri spavosti. Tieto podiely vyjadrujú výskyt ťažkostí podľa dotazníka. Nespavosť sa neoverovala klinickým rozhovorom a spavosť sa nehodnotila Epworthovou škálou [1].</p>

<h2>Denná spavosť, únava a funkcia obličiek</h2>
<p>Po zohľadnení veku a pohlavia sa albuminúria štatisticky významne nespájala ani s jedným zo sledovaných príznakov. Pri nespavosti sa nepreukázala ani súvislosť s eGFR. Pri dennej spavosti bol v modeli zohľadňujúcom aj sociálne faktory, pohybovú aktivitu, pridružené ochorenia a lieky pomer šancí 1,16 (95 % interval spoľahlivosti od 1,05 do 1,28) na každých 10 ml/min/1,73 m² nižšej eGFR. Ide o porovnanie šancí pri odlišnej eGFR. Model nevyjadruje zmenu individuálneho rizika pri poklese filtrácie v čase [1].</p>
<p>V plne upravenom modeli, ktorý zahŕňal aj únavu a ďalšie príznaky, sa odhad oslabil na 1,05 (95 % interval spoľahlivosti od 0,96 do 1,16). Čím viac pacientov trápila únava, tým vyššia bola šanca, že uvedú aj dennú spavosť. Súvislosť pretrvala po zohľadnení depresie, nespavosti a spánkového apnoe. Únava znamená pocit nedostatku energie alebo vyčerpania. Pri spavosti ide o sklon zaspať. Obe ťažkosti sa môžu vyskytovať naraz. Keďže sa posudzovali v tom istom období, oslabenie asociácie s eGFR neumožňuje určiť, či únava sprostredkúva vplyv nižšej filtrácie na spavosť [1].</p>

<h2>Nespavosť a záťaž príznakmi</h2>
<p>Šanca nespavosti stúpala s mierou, v akej pacientov obťažovali kŕče, svrbenie a obavy z ochorenia obličiek. Súvislosti pretrvali aj po zohľadnení ďalších faktorov vrátane depresie a spánkového apnoe. Benzodiazepíny s dlhým eliminačným polčasom sa spájali s dennou spavosťou v čiastočne upravenom modeli. V plne upravenom modeli už táto súvislosť nedosiahla štatistickú významnosť. Výsledky preto podporujú preverenie príznakov a liekov pri vyšetrení. Účinok liečby svrbenia či kŕčov alebo úpravy predpísaných liekov na spánok kohorta nehodnotila [1].</p>

<h2>Rozhovor v nefrologickej ambulancii</h2>
<p>Pri sťažnosti na zlý spánok sa oplatí rozlíšiť ťažkosti so zaspávaním a udržaním spánku, dennú spavosť a pocit vyčerpania. Pri nespavosti má zmysel spýtať sa, či pacienta v noci budí svrbenie alebo kŕče a či mu bránia zaspať obavy. Pri spavosti treba zistiť, či pacient cez deň nechcene zaspáva, preveriť dĺžku nočného spánku a prejsť užívané lieky vrátane sedatív. Pozorované prestávky v dýchaní počas spánku spolu s dennou spavosťou sú dôvodom posúdiť podozrenie na obštrukčné spánkové apnoe. Samotný dotazník na jeho diagnostiku nestačí. Pri potvrdenej chronickej nespavosti odporúča American Academy of Sleep Medicine viaczložkovú kognitívno-behaviorálnu terapiu nespavosti [1, 2, 3].</p>
<p>Opakované dotazníky umožnili skúmať súvislosti v početnej kohorte. Údaje o príznakoch však vychádzali z výpovedí pacientov, len 44 % pozorovaní obsahovalo všetky údaje a chýbajúce hodnoty autori dopĺňali viacnásobnou imputáciou. Časovú následnosť súvislostí analýza neurčila. Výsledky sa týkajú pacientov sledovaných v nefrologických ambulanciách pred dialýzou [1].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Bénédicte Stengel, Emilie Moutard, Marie Metzger, Isabelle Jaussent, Aghilès Hamroun, Solène M Laville, Abdou Omorou, Denis Fouque, Ziad A Massy, Roberto Pecoits-Filho, Luc Frimat, Natalia Alencar de Pinho, Sophie Liabeuf, CKD-REIN study investigators. Sleep Disturbances in Chronic Kidney Disease - The CKD-REIN Cohort Study. Kidney Med. 2026;8(11):101530. <a href="https://doi.org/10.1016/j.xkme.2026.101530">DOI a vydavateľ</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42899186/">PubMed 42899186</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13679367/">Plný text</a></em></small></li>
<li><small><em>Vishesh K Kapur, Dennis H Auckley, Susmita Chowdhuri, David C Kuhlmann, Reena Mehra, Kannan Ramar, Christopher G Harrod. Clinical Practice Guideline for Diagnostic Testing for Adult Obstructive Sleep Apnea: An American Academy of Sleep Medicine Clinical Practice Guideline. J Clin Sleep Med. 2017;13(3):479-504. <a href="https://doi.org/10.5664/jcsm.6506">DOI a vydavateľ</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/28162150/">PubMed 28162150</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC5337595/">Plný text</a></em></small></li>
<li><small><em>Jack D Edinger, J Todd Arnedt, Suzanne M Bertisch, Colleen E Carney, John J Harrington, Kenneth L Lichstein, Michael J Sateia, Wendy M Troxel, Eric S Zhou, Uzma Kazmi, Jonathan L Heald, Jennifer L Martin. Behavioral and psychological treatments for chronic insomnia disorder in adults: an American Academy of Sleep Medicine clinical practice guideline. J Clin Sleep Med. 2021;17(2):255-262. <a href="https://doi.org/10.5664/jcsm.8986">DOI a vydavateľ</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/33164742/">PubMed 33164742</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7853203/">Plný text</a></em></small></li>
</ol>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// POZOR: každý vložený článok zaradí samostatné avízo pre KAŽDÉHO odberateľa.
// Pri dávke N článkov to znamená N × počet odberateľov e-mailov naraz
// (2026-09-09: 12 článkov = 144 e-mailov). Preto je predvolená hodnota `false`.
// Na `true` prepni vedome — pri jednom článku, ktorý má ísť do newslettera.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_sleep_ckd_rein',
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
