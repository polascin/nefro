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
    'title'        => 'Lipoproteín(a) pri chronickej chorobe obličiek po štúdii Lp(a)HORIZON',
    'slug'         => 'lipoprotein-a-ckd-nla-2026',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Kedy pri chronickej chorobe obličiek zopakovať meranie Lp(a), ako výsledok ovplyvní prevenciu a čo ukázala štúdia Lp(a)HORIZON.',
    'content'      => <<<'HTML'
<figure><a href="img/lipoprotein-a-ckd-nla-2026.webp" target="_blank" rel="noopener noreferrer"><img src="img/lipoprotein-a-ckd-nla-2026.webp" alt="Častica lipoproteínu(a) pri stene tepny" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Častica lipoproteínu(a) pri stene tepny. Ilustračný obrázok.</figcaption></figure>
<p>Praktický prehľad National Lipid Association (NLA), ktorý Medscape spracoval v októbri 2026, odporúča stanoviť lipoproteín(a) [Lp(a)] aspoň raz u každého dospelého. Pri chronickej chorobe obličiek (CKD) môže výsledok spresniť odhad aterosklerotického kardiovaskulárneho rizika. Jeho interpretáciu však ovplyvňuje aj stav obličiek v čase odberu. Novembrové výsledky štúdie Lp(a)HORIZON zároveň ukázali, že výrazný pokles Lp(a) po pelakarsene neviedol k preukázanému poklesu kardiovaskulárnych príhod. [1, 2]</p>

<h2>Kedy pri CKD zopakovať meranie</h2>

<p>Koncentrácia Lp(a) je prevažne geneticky podmienená. Pri stabilnom klinickom stave obyčajne stačí jednorazové stanovenie. Podľa NLA sa za vysokú považuje hodnota ≥125 nmol/l alebo ≥50 mg/dl. Ide o rozhodovacie hranice pre výsledky vydané v príslušnej jednotke. Veľkosť izoforiem apolipoproteínu(a) sa medzi ľuďmi líši, preto univerzálny prepočítavací koeficient medzi mg/dl a nmol/l neexistuje. Riziko stúpa kontinuálne a klinický význam výsledku závisí aj od ostatných rizikových faktorov. [1, 3]</p>

<p>Lp(a) môže stúpnuť pri zhoršenej funkcii obličiek a výraznej proteinúrii, najmä pri nefrotickom syndróme. Zvýšenie bolo opísané aj pri peritoneálnej dialýze. Po úspešnej transplantácii obličky môže koncentrácia klesnúť. Ak bol prvý výsledok v hraničnom pásme a odvtedy sa významne zmenila funkcia obličiek, má zmysel zvážiť nové stanovenie. Podobne možno zvážiť kontrolný odber po ústupe nefrotického syndrómu, ak by výsledok ovplyvnil posúdenie rizika alebo rozhodnutie o vyšetrení rodiny. Pre porovnateľnosť je vhodné použiť rovnakú laboratórnu metódu. [1, 3]</p>

<h2>Čo vysoký výsledok mení v prevencii</h2>

<p>Pri CKD má liečba zameraná na LDL cholesterol vlastné indikácie. KDIGO odporúča u dospelých od 50 rokov s eGFR &lt;60 ml/min/1,73 m², ktorí nie sú liečení chronickou dialýzou a nemajú transplantovanú obličku, statín alebo kombináciu statínu s ezetimibom. Zvýšený Lp(a) je ďalší dôvod skontrolovať, či intenzita znižovania LDL cholesterolu zodpovedá celkovému riziku a či sú primerane ovplyvnené krvný tlak, fajčenie a diabetes. Statín má význam aj vtedy, keď koncentrácia Lp(a) neklesne. [1, 4]</p>

<p>Pri chronickej dialýze samotný vysoký Lp(a) neodôvodňuje začatie liečby statínom. KDIGO pri dialýze vo všeobecnosti navrhuje statín ani kombináciu s ezetimibom nezačínať a pokračovať v už zavedenej liečbe pri prechode na dialýzu. Po transplantácii obličky sa u dospelých statín navrhuje, pričom výber ovplyvňujú interakcie s imunosupresívami. V sekundárnej prevencii sa o ďalšom znižovaní LDL cholesterolu rozhoduje podľa celkového rizika, dosiahnutej koncentrácie LDL cholesterolu a tolerancie liečby. [1, 4, 5]</p>

<h2>Lp(a)HORIZON po vydaní prehľadu NLA</h2>

<p>V randomizovanej, dvojito zaslepenej štúdii fázy 3 boli zaradení pacienti s preukázaným kardiovaskulárnym ochorením a Lp(a) ≥70 mg/dl. Z 8 350 randomizovaných účastníkov bolo 8 322 zahrnutých do analýzy účinnosti. Pri mediáne sledovania 4,7 roka nastal primárny kombinovaný ukazovateľ u 511 zo 4 157 účastníkov liečených pelakarsenom (12,3 %) a u 503 zo 4 165 účastníkov s placebom (12,1 %). Pomer hazardov bol 1,02 (95 % interval spoľahlivosti 0,90 až 1,15, p = 0,76). Ukazovateľ zahŕňal kardiovaskulárne úmrtie, nefatálny infarkt myokardu, nefatálnu cievnu mozgovú príhodu a urgentnú koronárnu revaskularizáciu. Po 12 mesiacoch bol medián koncentrácie Lp(a) 64,4 nmol/l v skupine s pelakarsenom a 233,4 nmol/l v skupine s placebom. [2]</p>

<p>Lp(a)HORIZON skúšala konkrétny liek v sekundárnej prevencii. Liečbu predčasne ukončilo 35,1 % účastníkov v skupine s pelakarsenom a 18,3 % v skupine s placebom. Výsledok teda opisuje účinok pridelenia k liečbe v podmienkach štúdie. Meranie Lp(a) má naďalej oporu v dôkazoch o jeho vzťahu k aterosklerotickému riziku. O účinnosti ďalších liekov cielených na Lp(a) rozhodnú ich vlastné štúdie s klinickými výsledkami. V nefrologickej ambulancii dnes vysoký výsledok pomáha najmä pri posúdení celkového rizika a pri rozhodovaní, ako dôsledne ovplyvniť faktory, pre ktoré už máme účinnú liečbu. [1, 2, 3]</p>

<p><a href="article.php?slug=lipoprotein-a-kardiovaskularne-riziko-primarna-starostlivost">Súvisiaci článok o skríningu Lp(a) v primárnej starostlivosti</a></p>

<hr>
<h2>Zdroje</h2>
<p><small><em>Východiskový prehľad. Lipoprotein(a) Management Simplified. Medscape, 1. októbra 2026. <a href="https://reference.medscape.com/cc2/p10/lipoprotein-management-simplified-guideline-nla-2026a10010dl" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></small></p>
<ol>
<li><small><em>Marlys L. Koschinsky, Christie M. Ballantyne. Lipoprotein(a) management simplified: The National Lipid Association lipid simplified series. J Clin Lipidol. Online 24. septembra 2026. <a href="https://doi.org/10.1016/j.jacl.2026.09.013" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42869709/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://www.lipid.org/resource/lipoproteina-management-simplified-the-national-lipid-association-lipid-simplified-series/" target="_blank" rel="noopener noreferrer">NLA</a>.</em></small></li>
<li><small><em>Leslie Cho, Stephen J. Nicholls, Seth Frndak, Kathy Wolski, Børge G. Nordestgaard, Brian Manning, Eran Leitersdorf, Ulf Landmesser, Venu Menon, Jackie McCluskey, Michael J. Blaha, Ryuichi Morishita, A. Michael Lincoff, Ziqiang Zhao, Jing Wang, Raul D. Santos, Ioanna Gouni-Berthold, Sotirios Tsimikas, Anastasia Lesogor, Hui Cao, Steven E. Nissen, za skupinu Lp(a)HORIZON Investigators. Pelacarsen and Cardiovascular Outcomes in Patients with High Lipoprotein(a). N Engl J Med. Online 7. novembra 2026. <a href="https://doi.org/10.1056/NEJMoa2610159" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/43001734/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Florian Kronenberg, Samia Mora, Erik S. G. Stroes, Brian A. Ference, Benoit J. Arsenault, Lars Berglund, Marc R. Dweck, Marlys Koschinsky, Gilles Lambert, François Mach, Catherine J. McNeal, Patrick M. Moriarty, Pradeep Natarajan, Børge G. Nordestgaard, Klaus G. Parhofer, Salim S. Virani, Arnold von Eckardstein, Gerald F. Watts, Jane K. Stock, Kausik K. Ray, Lale S. Tokgözoğlu, Alberico L. Catapano. Lipoprotein(a) in atherosclerotic cardiovascular disease and aortic stenosis: a European Atherosclerosis Society consensus statement. Eur Heart J. 2022;43(39):3925-3946. <a href="https://doi.org/10.1093/eurheartj/ehac361" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/36036785/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117-S314. Oddiel 3.15. <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>KDIGO Lipid Work Group. KDIGO Clinical Practice Guideline for Lipid Management in Chronic Kidney Disease. Kidney Int Suppl. 2013;3(3):259-305. Odporúčania 2.3.1, 2.3.2 a 2.4. <a href="https://kdigo.org/guidelines/lipids-in-ckd/" target="_blank" rel="noopener noreferrer">KDIGO</a>.</em></small></li>
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
    'log_prefix' => 'add_lipoprotein-a-ckd-nla-2026_article',
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
