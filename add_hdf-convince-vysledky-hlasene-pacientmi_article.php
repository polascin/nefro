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
    'title'        => 'Vysokoobjemová hemodiafiltrácia a výsledky hlásené pacientmi v štúdii CONVINCE',
    'slug'         => 'hdf-convince-vysledky-hlasene-pacientmi',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Podskupinová analýza CONVINCE neposkytla oporu pre výber pacientov na vysokoobjemovú hemodiafiltráciu podľa veku, diabetu, typu cievneho prístupu ani reziduálnej diurézy.',
    'content'      => <<<'HTML'
<figure><img src="img/hdf-convince-vysledky-hlasene-pacientmi.webp" alt="Dialyzačný prístroj vedľa kresla s pacientom" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia dialyzačného pracoviska vytvorená pomocou umelej inteligencie.</figcaption></figure>

<p>V štúdii CONVINCE sa pri vysokoobjemovej hemodiafiltrácii niektoré ukazovatele kvality života zhoršovali pomalšie než pri hemodialýze s vysokopriepustnou membránou. Následná podskupinová analýza neposkytla presvedčivý dôkaz, že by sa tento účinok klinicky významne menil podľa veku, diabetu, typu cievneho prístupu alebo reziduálnej diurézy. Výsledky preto nepodporujú používanie týchto znakov ako samostatných kritérií výberu pacientov na základe očakávanej kvality života [1, 2].</p>

<h2>Koho a čo sledovala štúdia CONVINCE</h2>

<p>Do otvorenej multicentrickej randomizovanej štúdie zaradili 1 360 dospelých pacientov so zlyhaním obličiek, ktorí najmenej tri mesiace podstupovali hemodialýzu s vysokopriepustnou membránou (HD). Pred zaradením museli byť schopní vyplniť dotazníky a podľa posúdenia pracoviska mali byť schopní dosiahnuť konvekčný objem aspoň 23 l na jednu dialýzu. Štúdia porovnávala online postdilučnú hemodiafiltráciu (HDF) s týmto cieľovým objemom a pokračovanie v HD. Priemerný dosiahnutý konvekčný objem v skupine HDF bol 25,3 l na dialýzu [3].</p>

<p>Vopred špecifikovaná exploračná podskupinová analýza zahŕňala 1 211 pacientov s dotazníkovými údajmi pri vstupe aj počas sledovania. Medián sledovania bol 30 mesiacov. Každé tri mesiace pacienti hodnotili osem oblastí pomocou dotazníkov PROMIS (Patient-Reported Outcomes Measurement Information System). Sledovali telesnú a kognitívnu funkciu, únavu, poruchy spánku, úzkosť, depresiu, obmedzenie bežných činností bolesťou a účasť na spoločenskom živote. Hodnotenie kognitívnej funkcie vyjadrovalo, ako ju vnímal sám pacient [1, 2].</p>

<h2>Čo ukázali porovnania v podskupinách</h2>

<p>Autori testovali, či sa rozdiel medzi HDF a HD v priebehu jednotlivých ukazovateľov mení podľa veku, pohlavia, diabetu, kardiovaskulárneho ochorenia, dĺžky doterajšej dialyzačnej liečby, typu cievneho prístupu alebo reziduálneho objemu moču. Upravené zmiešané modely ukázali nominálne interakcie pri dĺžke liečby a telesnej funkcii (<i>p</i> = 0,03), veku a obmedzení bežných činností bolesťou (<i>p</i> = 0,02) a dĺžke liečby a poruchách spánku (<i>p</i> = 0,04) [1].</p>

<p>Keď pacient zomrie, jeho ďalšie dotazníkové údaje chýbajú. Výpadok tým môže súvisieť so zdravotným stavom a skresliť porovnanie priebehu skóre. Autori preto v analýze citlivosti modelovali súčasne priebeh skóre aj čas do úmrtia. Zopakovali sa interakcie týkajúce sa telesnej funkcie a obmedzenia bolesťou. Objavili sa aj nominálne interakcie pri type cievneho prístupu a poruchách spánku (<i>p</i> = 0,03) a pri kardiovaskulárnom ochorení a kognitívnej funkcii (<i>p</i> = 0,05) [1].</p>

<p>Rozdiely v účinku boli podľa autorov malé, v príbuzných oblastiach sa neobjavovali konzistentne a hodnoty <i>p</i> neboli upravené na viacnásobné porovnávanie. Pri početných testoch možno niekoľko nízkych hodnôt <i>p</i> očakávať aj náhodou. Zopakovanie dvoch interakcií v inom modeli svedčí o ich odolnosti voči zmene analytického postupu v tej istej vzorke. Na potvrdenie by boli potrebné nezávislé údaje a presvedčivé odhady veľkosti rozdielov. Analýza ponecháva otvorenú možnosť skutočných rozdielov medzi podskupinami a neumožňuje predpovedať prínos pre jednotlivca [1].</p>

<h2>Kvalita života a prežívanie sú rôzne výsledky</h2>

<p>V pôvodnej analýze kvality života sa skóre v oboch skupinách postupne zhoršovalo. V spoločnom modeli so zohľadnením úmrtí bol pri HDF pokles pomalší v štyroch oblastiach: telesná funkcia, pacientom vnímaná kognitívna funkcia, obmedzenie bežných činností bolesťou a účasť na spoločenskom živote. Najvýraznejší rozdiel v zmene skóre autori zaznamenali pri kognitívnej funkcii. Primárnym výsledkom štúdie bola celková mortalita. Zomrelo 118 zo 683 pacientov pri HDF (17,3 %) a 148 zo 677 pri HD (21,9 %). Pomer hazardov bol 0,77 (95 % interval spoľahlivosti od 0,65 do 0,93). Podskupinová analýza dotazníkov neriešila, či sa účinok na mortalitu medzi podskupinami líši [1, 2, 3].</p>

<p>Konsenzus pracovnej skupiny EuDial Európskej renálnej asociácie upozorňuje na rozdiely medzi štúdiami v použitých dotazníkoch, populáciách aj dialyzačných režimoch. Talianska nefrologická spoločnosť hodnotí istotu dôkazov o pomalšom zhoršovaní vybraných ukazovateľov hlásených pacientmi ako nízku. Aktualizovaný prehľad Cochrane, ktorý zahŕňa širší okruh konvektívnych metód a porovnávacích režimov, našiel pri únave a telesnej zložke kvality života neisté odhady blízke nulovému rozdielu. Rozsah možného prínosu preto závisí aj od toho, čo sa meria a aký dialyzačný režim sa porovnáva [4, 5, 6].</p>

<h2>Čo z toho vyplýva pre dialyzačné stredisko</h2>

<p>Vyšší vek, diabetes ani zachovaná reziduálna diuréza samy osebe neposkytujú na základe tejto analýzy dôvod vyradiť pacienta z úvahy o HDF. Pri cievnom prístupe má praktický význam jeho funkcia: či pri primeranom trvaní dialýzy umožňuje bezpečne udržať potrebný prietok krvi a dosahovať predpísaný konvekčný objem. Výsledok podskupinovej analýzy podľa typu prístupu túto technickú otázku nerieši. Pri rozhovore s pacientom má zmysel pomenovať oblasti, ktoré sa ho bezprostredne týkajú, a sledovať ich vývoj po zmene liečby [1, 3, 5].</p>

<p>Otvorený dizajn mohol ovplyvniť odpovede v dotazníkoch. Podskupinová analýza navyše zahŕňala len účastníkov s údajmi pri vstupe aj počas sledovania. Výsledky sa najpriamejšie vzťahujú na pacientov podobných účastníkom CONVINCE, u ktorých možno vysokoobjemovú postdilučnú HDF uskutočniť. Cieľ 23 l na dialýzu v tomto porovnaní vychádza z protokolu štúdie [1, 3].</p>

<p><small>Podskupinové výsledky vychádzajú z verejne dostupného abstraktu CJASN.</small></p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Krister Cromm, Felix Fischer, Giovanni Pellegrino, Robin W M Vernooij, Leili Riazy, Claudia Barth, Peter J Blankestijn, Michiel L Bots, Bernard Canaud, Andrew Davenport, Jörgen Hegbrant, Mark Woodward, Matthias Rose, Giovanni F M Strippoli. Patient-Reported Outcomes with High-Volume Hemodiafiltration Versus High-Flux Hemodialysis Across Clinical Subgroups: Results from the CONVINCE Trial. Clin J Am Soc Nephrol. Publikované online 30. októbra 2026. <a href="https://doi.org/10.2215/CJN.0000001253" target="_blank" rel="noopener noreferrer">DOI 10.2215/CJN.0000001253</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42961497/" target="_blank" rel="noopener noreferrer">PubMed 42961497</a> · <a href="https://www.ovid.com/jnls/cjasn/abstract/10.2215/cjn.0000001253~patient-reported-outcomes-with-high-volume-hemodiafiltration" target="_blank" rel="noopener noreferrer">Vydavateľ</a></em></small></li>
<li><small><em>Matthias Rose, Felix H Fischer, Gregor Liegl, Giovanni F M Strippoli, Carina Hockham, Robin W M Vernooij, Claudia Barth, Bernard Canaud, Adrian Covic, Krister Cromm, Andrea M Cucui, Andrew Davenport, Kathrin I Fischer, Jörgen Hegbrant, Hanna Jaha, Anna Schappert, Marietta Török, Mark Woodward, Michiel L Bots, Peter J Blankestijn, CONVINCE Scientific Committee and CONVINCE Investigators. The CONVINCE randomized trial found positive effects on quality of life for patients with chronic kidney disease treated with hemodiafiltration. Kidney Int. 2024;106(5):961-971. <a href="https://doi.org/10.1016/j.kint.2024.07.014" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.kint.2024.07.014</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/39089577/" target="_blank" rel="noopener noreferrer">PubMed 39089577</a> · <a href="https://linkinghub.elsevier.com/retrieve/pii/S0085253824005349" target="_blank" rel="noopener noreferrer">Vydavateľ</a></em></small></li>
<li><small><em>Peter J Blankestijn, Robin W M Vernooij, Carinna Hockham, Giovanni F M Strippoli, Bernard Canaud, Jörgen Hegbrant, Claudia Barth, Adrian Covic, Krister Cromm, Andrea Cucui, Andrew Davenport, Matthias Rose, Marietta Török, Mark Woodward, Michiel L Bots, CONVINCE Scientific Committee Investigators. Effect of Hemodiafiltration or Hemodialysis on Mortality in Kidney Failure. N Engl J Med. 2023;389(8):700-709. <a href="https://doi.org/10.1056/NEJMoa2304820" target="_blank" rel="noopener noreferrer">DOI 10.1056/NEJMoa2304820</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/37326323/" target="_blank" rel="noopener noreferrer">PubMed 37326323</a> · <a href="https://www.nejm.org/doi/full/10.1056/NEJMoa2304820" target="_blank" rel="noopener noreferrer">Vydavateľ</a></em></small></li>
<li><small><em>Yuri Battaglia, Rukshana Shroff, Björn Meijers, Ionut Nistor, Gaetano Alfano, Casper Franssen, Valerie Luyckx, Vassilios Liakopoulos, Alessandro Mantovani, Federica Baciga, Federica Caccia, Claudia Momentè, Andrew Davenport, Peter J Blankestijn, Adrian Covic, Christian Combe, Carlo Basile. Haemodiafiltration versus high-flux haemodialysis-a Consensus Statement from the EuDial Working Group of the ERA. Nephrol Dial Transplant. 2025;40(8):1590-1614. <a href="https://doi.org/10.1093/ndt/gfaf024" target="_blank" rel="noopener noreferrer">DOI 10.1093/ndt/gfaf024</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/39914451/" target="_blank" rel="noopener noreferrer">PubMed 39914451</a> · <a href="https://academic.oup.com/ndt/article/40/8/1590/8003757" target="_blank" rel="noopener noreferrer">Vydavateľ</a></em></small></li>
<li><small><em>Giovanni F M Strippoli, Giovanni Pellegrino, Jörgen Hegbrant, Paolo Fabbrini, Paolo Luca Maria Lentini, Filippo Aucella, Vincenzo Panichi, Maurizio Gallieni, Bernard Canaud, Andrew Davenport, Alberto Ortiz, Rosa Ramos, Jolanta Malyszko, Rümeyza Kazancıoğlu, Martin Kuhlman, Ana Carina Ferreira, Krister Cromm, Sagar Nigwekar, Allen R Nissenson, Luca De Nicola. Online hemodiafiltration for kidney failure: guidance and best clinical practice recommendations from the Italian Society of Nephrology. J Nephrol. Publikované online 19. augusta 2026. aajag225. <a href="https://doi.org/10.1093/joneph/aajag225" target="_blank" rel="noopener noreferrer">DOI 10.1093/joneph/aajag225</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42614082/" target="_blank" rel="noopener noreferrer">PubMed 42614082</a> · <a href="https://academic.oup.com/joneph/advance-article/doi/10.1093/joneph/aajag225/8764265" target="_blank" rel="noopener noreferrer">Vydavateľ</a></em></small></li>
<li><small><em>Robin Wm Vernooij, Giovanni Fm Strippoli, Denise Mj Veltkamp, Ionut Nistor, Jonathan C Craig, Valeria M Saglimbene, Adrian C Covic, Mariacristina Vecchio, supported by Cochrane Kidney and Transplant. Haemodiafiltration, haemofiltration and haemodialysis for adults with kidney failure. Cochrane Database Syst Rev. 2026;10(10):CD006258. <a href="https://doi.org/10.1002/14651858.CD006258.pub3" target="_blank" rel="noopener noreferrer">DOI 10.1002/14651858.CD006258.pub3</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42867023/" target="_blank" rel="noopener noreferrer">PubMed 42867023</a></em></small></li>
</ol>

<h3>Súvisiaci článok</h3><p><a href="article.php?slug=online-hemodiafiltracia-davkovana-liecba-odporucania-sin">Online hemodiafiltrácia ako dávkovaná liečba podľa odporúčaní Talianskej nefrologickej spoločnosti</a></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_hdf_convince_vysledky_hlasene_pacientmi',
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
