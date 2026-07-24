<?php
/**
 * add_vona-cokolady-vykon-pri-silovom-treningu_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = 'odborne'): môže vôňa čokolády zlepšiť výkon pri
 * silovom tréningu? Slovenské spracovanie exploratívnej štúdie (Fan a kol.,
 * Frontiers in Physiology 2026) a jej pokrytia v Medscape, doplnené o vecnú
 * kontrolu a nefrologickú poznámku. Pôvodní autori zdroja sú v source_authors.php.
 *
 * Postup:
 *   1. git add + git commit  →  deploy hook nahrá súbor na server
 *   2. Spusti cez SSH:
 *      ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *          uid58858@shell.r1.websupport.sk \
 *          "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_vona-cokolady-vykon-pri-silovom-treningu_article.php"
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
require_once __DIR__ . '/article_publisher.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Môže vôňa čokolády zlepšiť výkon pri silovom tréningu?',
    'slug'         => 'vona-cokolady-vykon-pri-silovom-treningu',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Malá randomizovaná skrížená štúdia u mladých mužov cvičiacich nalačno naznačuje, že vôňa horkej čokolády môže zvýšiť počet extenzií kolena a potlačiť hlad. Výsledky sú predbežné – nejde o overený ergogénny účinok.',
    'content'      => <<<'HTML'
<p>Vôňa jedla ovplyvňuje chuť do jedla, emócie, očakávanie odmeny aj autonómne reakcie organizmu. Nová experimentálna štúdia naznačuje, že krátkodobá expozícia vôni čokolády môže počas tréningu nalačno zvýšiť tréningový objem pri silovom cvičení dolných končatín. Najvýraznejší účinok sa pozoroval pri vôni horkej čokolády s vysokým obsahom kakaa.</p>

<p>Výsledok je zaujímavý, no zatiaľ ho nemožno považovať za dôkaz prakticky významného ergogénneho účinku. Išlo o malú exploratívnu štúdiu vykonanú iba na mladých zdravých mužoch a pri jedinom type cvičenia.</p>

<h2>Ako bola štúdia navrhnutá</h2>

<p>Výskumníci zaradili 23 zdravých, rekreačne trénovaných mužov s priemerným vekom približne 23 rokov. Každý účastník absolvoval tri experimentálne podmienky v náhodnom poradí:</p>

<ul>
  <li>vôňu horkej čokolády s obsahom 90 % kakaa,</li>
  <li>vôňu mliečnej čokolády s obsahom 60 % kakaa,</li>
  <li>kontrolnú podmienku s vodou bez vône.</li>
</ul>

<p>Štúdia mala randomizovaný dvojito zaslepený skrížený dizajn. Každý účastník teda absolvoval všetky tri podmienky a slúžil ako vlastná kontrola. Takýto postup znižuje vplyv rozdielov vo výkonnosti medzi jednotlivcami.</p>

<p>Testovanie prebiehalo nalačno, po minimálne 10 hodinách bez jedla. Účastníci boli vôni vystavení pred cvičením aj medzi jednotlivými sériami. Následne vykonávali extenzie v kolennom kĺbe (leg extension) v sériách po 10 opakovaniach so záťažou zodpovedajúcou 80 % ich 10-opakovacieho maxima (10RM), a to až do vyčerpania, s prestávkami približne 3,5 minúty medzi sériami. Hlavným sledovaným výsledkom bol celkový počet opakovaní vykonaných počas tréningovej jednotky.</p>

<p>Výskumníci zároveň hodnotili subjektívny hlad, pocit sýtosti, príjemnosť vône, vnímanú náročnosť cvičenia a afektívne prežívanie počas záťaže.</p>

<h2>Hlavné výsledky</h2>

<p>V porovnaní s kontrolnou podmienkou vykonali účastníci po expozícii vôni horkej čokolády v priemere približne o 18 opakovaní viac. Vôňa mliečnej čokolády bola spojená približne s deviatimi dodatočnými opakovaniami.</p>

<p>Horká čokoláda zároveň výraznejšie potlačila subjektívny hlad. Mliečna čokoláda bola hodnotená ako príjemnejšia, čo sa prejavilo priaznivejším afektívnym hodnotením tréningu. Vnímaná náročnosť cvičenia sa však medzi podmienkami významne nelíšila.</p>

<p>To znamená, že účastníci zvládli vyšší tréningový objem bez toho, aby cvičenie subjektívne hodnotili ako náročnejšie. Štúdia však neposkytuje dôkaz, že vôňa zvýšila maximálnu svalovú silu. Hodnotila počet opakovaní pri submaximálnej záťaži, teda skôr lokálnu svalovú vytrvalosť a celkový tréningový objem.</p>

<h2>Ako by mohla vôňa ovplyvňovať výkon</h2>

<p>Čuchové podnety sú úzko prepojené s limbickým systémom, emóciami, pamäťou, motiváciou a spracovaním odmeny. Príjemná vôňa môže meniť náladu, pozornosť, očakávanie aj toleranciu nepohodlia. Potravinové vône navyše aktivujú cefalickú fázu odpovede na jedlo a môžu ovplyvniť vnímanie hladu alebo sýtosti.</p>

<p>Autori predpokladajú, že potlačenie hladu mohlo znížiť rušivý účinok potravinovej motivácie počas cvičenia nalačno. Vyšší výkon mohol súvisieť aj s príjemnosťou podnetu, očakávaním odmeny alebo zvýšenou motiváciou pokračovať v cvičení.</p>

<p>Tieto vysvetlenia však zostávajú hypotetické. V štúdii sa nemerali:</p>

<ul>
  <li>β-endorfíny,</li>
  <li>katecholamíny,</li>
  <li>kortizol,</li>
  <li>dopamínová aktivita,</li>
  <li>mozgová odpoveď na vôňu,</li>
  <li>neuromuskulárna aktivácia,</li>
  <li>metabolické parametre počas záťaže.</li>
</ul>

<p>Tvrdenie, že účinok sprostredkovali endorfíny, preto nie je priamo podložené výsledkami experimentu. Rovnako nie je dôvod pripisovať okamžitý výkonnostný efekt črevnému mikrobiómu – účastníci čokoládu nekonzumovali a skúmaná intervencia bola krátkodobá.</p>

<h2>Čo vieme o vôňach a výkone</h2>

<p>Staršie experimenty naznačili, že niektoré vône, napríklad mäta pieporná, môžu ovplyvniť bdelosť, náladu alebo výkon pri vybraných pohybových úlohách. Výsledky však nie sú jednotné a jednotlivé štúdie používajú odlišné vône, koncentrácie, spôsoby aplikácie aj výkonnostné testy.</p>

<p>Podobne nejednoznačné sú poznatky o vplyve potravinových vôní na apetít. Niektoré experimenty zaznamenali potlačenie hladu, iné zvýšenie chuti do jedla alebo žiadny významný účinok. Výsledok zrejme závisí od dĺžky expozície, stavu nalačno, príjemnosti vône, očakávania jedla aj individuálnej citlivosti.</p>

<p>Nová štúdia preto skôr otvára výskumnú otázku, než by poskytovala definitívnu odpoveď.</p>

<h2>Dôležité obmedzenia</h2>

<h3>Malý a homogénny súbor</h3>
<p>Štúdia zahŕňala iba 23 mladých mužov. Výsledky nemožno automaticky prenášať na ženy, starších ľudí, profesionálnych športovcov ani osoby s chronickými ochoreniami.</p>

<h3>Jediný druh cvičenia</h3>
<p>Hodnotili sa extenzie kolena na stroji. Nie je známe, či by sa účinok prejavil pri drepoch, chôdzi, behu, celotelovom silovom tréningu alebo vytrvalostnom cvičení.</p>

<h3>Testovanie nalačno</h3>
<p>Experiment sa uskutočnil v stave nalačno. Potlačenie hladu preto mohlo byť pre výsledok podstatné. Po jedle môže byť odpoveď odlišná alebo úplne neprítomná.</p>

<h3>Problematické zaslepenie</h3>
<p>Hoci autori štúdiu označujú za dvojito zaslepenú, vôňu čokolády oproti nearomatizovanej vode účastníci pravdepodobne ľahko rozpoznali. Úplné zaslepenie čuchového podnetu je náročné, a preto nemožno vylúčiť očakávanie účinku, placebo efekt ani zvýšenú motiváciu vyvolanú atraktívnou vôňou.</p>

<h3>Absolútny počet opakovaní môže zavádzať</h3>
<p>Údaj o 18 dodatočných opakovaniach znie výrazne, no bez kontextu celkového počtu sérií, opakovaní a veľkosti štandardizovaného účinku neumožňuje presne posúdiť klinickú či športovú významnosť rozdielu.</p>

<h3>Bez informácie o dlhodobom účinku</h3>
<p>Jednorazovo vyšší tréningový objem neznamená automaticky väčší rast svalov, zvýšenie sily alebo lepšiu kondíciu. To by musela potvrdiť dlhodobá tréningová štúdia.</p>

<h2>Má vôňa čokolády praktický význam?</h2>

<p>Krátka expozícia príjemnej vôni je jednoduchá a energeticky neutrálna intervencia. Môže byť zaujímavá pre ľudí trénujúcich nalačno alebo pre výskum motivácie počas cvičenia. Zatiaľ však nejde o overenú metódu zvyšovania športového výkonu.</p>

<p>Pred praktickým odporúčaním sú potrebné väčšie štúdie, ktoré:</p>

<ul>
  <li>zahrnú ženy a rôzne vekové skupiny,</li>
  <li>použijú dôveryhodnú kontrolnú vôňu,</li>
  <li>oddelia vplyv čokoládovej arómy od všeobecného účinku príjemnej vône,</li>
  <li>porovnajú stav nalačno a po jedle,</li>
  <li>preskúmajú ďalšie druhy cvičenia,</li>
  <li>zaznamenajú fyziologické a neuroendokrinné parametre,</li>
  <li>overia dlhodobý vplyv na silu, svalovú hmotu a tréningovú adaptáciu.</li>
</ul>

<h2>Nefrologický pohľad</h2>

<p>Pre pacientov s chronickým ochorením obličiek nemajú tieto výsledky priamy klinický význam. Štúdia nezahŕňala pacientov s CKD ani ľudí liečených dialýzou.</p>

<p>Samotné ovoňanie čokolády nepredstavuje príjem draslíka, fosforu, cukru ani energie. Teoreticky preto môže sprostredkovať príjemný senzorický zážitok bez nutnosti konzumácie čokolády. Nemožno však tvrdiť, že zlepšuje fyzickú výkonnosť, apetít alebo rehabilitáciu nefrologických pacientov.</p>

<p>Pri dialýze navyše treba zohľadniť individuálnu toleranciu vôní. Intenzívne arómy môžu u pacientov s nauzeou, migrénou alebo precitlivenosťou vyvolať nepríjemné príznaky.</p>

<h2>Záver</h2>

<p>Malá randomizovaná dvojito zaslepená skrížená štúdia naznačila, že vôňa čokolády môže u mladých zdravých mužov cvičiacich nalačno zvýšiť počet vykonaných extenzií kolena. Výraznejší účinok sa pozoroval pri horkej čokoláde, ktorá zároveň viac potlačila subjektívny hlad.</p>

<p>Výsledky sú predbežné. Nepotvrdzujú zvýšenie maximálnej sily, dlhodobé zlepšenie tréningovej adaptácie ani konkrétny biologický mechanizmus. Vôňu čokolády preto možno zatiaľ považovať za zaujímavý experimentálny podnet, nie za vedecky overený ergogénny prostriedok.</p>

<h2>Zdroje</h2>

<ol>
  <li>Fan X, Deng H, Ng JY, Ab Aziz AAH, Naharudin MN. <em>Chocolate odor enhances resistance exercise performance through appetite suppression in the fasted state: an exploratory study.</em> Frontiers in Physiology (2026); 17: 1834757. DOI: 10.3389/fphys.2026.1834757. <a href="https://www.frontiersin.org/journals/physiology/articles/10.3389/fphys.2026.1834757/full" target="_blank" rel="noopener noreferrer">frontiersin.org</a></li>
  <li><em>Can Sniffing Chocolate Boost Leg Workout Performance?</em> Medscape Medical News (2026). <a href="https://www.medscape.com/viewarticle/can-sniffing-chocolate-boost-leg-workout-performance-2026a1000nlf" target="_blank" rel="noopener noreferrer">medscape.com</a></li>
  <li>Nguyen NPK, Tran KN, Nguyen LTH, Shin HM, Yang IJ. <em>Effects of Essential Oils and Fragrant Compounds on Appetite: A Systematic Review.</em> International Journal of Molecular Sciences (2023); 24(9): 7962. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10178777/" target="_blank" rel="noopener noreferrer">pmc.ncbi.nlm.nih.gov</a></li>
  <li>Girona-Ruíz D, Cano-Lamadrid M, Carbonell-Barrachina ÁA, López-Lluch D, Sendra E. <em>Aromachology Related to Foods, Scientific Lines of Evidence: A Review.</em> Applied Sciences (2021); 11(13): 6095. DOI: 10.3390/app11136095. <a href="https://www.mdpi.com/2076-3417/11/13/6095" target="_blank" rel="noopener noreferrer">mdpi.com</a></li>
  <li>Raudenbush B, Corley N, Eppich W. <em>Enhancing Athletic Performance through the Administration of Peppermint Odor.</em> Journal of Sport and Exercise Psychology (2001); 23(2): 156–160. <a href="https://journals.humankinetics.com/view/journals/jsep/23/2/article-p156.xml" target="_blank" rel="noopener noreferrer">journals.humankinetics.com</a></li>
</ol>

<hr>

<p><em>Tento text má informatívny charakter a je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické posúdenie ani odbornú konzultáciu.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$__articleLogPrefix = basename(__FILE__, '.php');
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => $__articleLogPrefix,
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
