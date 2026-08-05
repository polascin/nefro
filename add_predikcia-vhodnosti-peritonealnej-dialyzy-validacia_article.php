<?php

/**
 * add_predikcia-vhodnosti-peritonealnej-dialyzy-validacia_article.php
 * Predikcia vhodnosti peritonealnej dialyzy - validacia a prirastkova hodnota.
 *
 * Povodni autori spracovaneho zdroja su uvedeni v source_authors.php.
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

$articles = [];

$articles[] = [
    'title'        => 'Predikcia vhodnosti peritoneálnej dialýzy: model, ktorý potrebuje validáciu a jasnú prírastkovú hodnotu',
    'slug'         => 'predikcia-vhodnosti-peritonealnej-dialyzy-validacia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kanadský model predpovedá, ktorý pacient bude uznaný za vhodného na peritoneálnu dialýzu. Jeho rozlišovacia schopnosť je však len mierna — a hlavne: model predpovedá rozhodnutie lekára, nie osud pacienta. Tomu zodpovedá aj kritika v liste redakcii.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Peritoneálna dialýza zostáva v mnohých krajinách nedostatočne využívaná a prediktívne modely sľubujú pomoc pri výbere vhodných pacientov. List redakcii <em>Peritoneal Dialysis International</em> upozorňuje, že bez externej validácie a bez preukázanej prírastkovej hodnoty ide skôr o zdanie objektivity. Pohľad na samotný model ukazuje, že výhrada je opodstatnená — a že skutočné úzke miesto leží inde.</em></p>

<p>Rozhodovanie o vhodnosti peritoneálnej dialýzy je v praxi zložité. Vstupuje doň kognitívny a funkčný stav pacienta, manuálna zručnosť, podmienky v domácnosti, dostupnosť pomoci, predchádzajúce brušné operácie, očakávania pacienta — a napokon aj kapacita programu na zaškolenie a na riešenie komplikácií. Časť týchto faktorov sa dá zaznamenať, časť nie.</p>

<p>Do tejto medzery vstupujú prediktívne modely. Otázka je, či pomáhajú.</p>

<h2>Model, o ktorý ide</h2>

<p>Yang Yang a spolupracovníci z University of Waterloo a University of Calgary zostavili logistickou regresiou model predpovedajúci, ktorý pacient bude považovaný za vhodného na peritoneálnu dialýzu. Vychádzali z <strong>598 účastníkov</strong> z nemocníc v provincii Alberta v rokoch <strong>2016 až 2018</strong>.</p>

<p>S nižšou pravdepodobnosťou uznania za vhodného na peritoneálnu dialýzu boli štatisticky významne spojené:</p>

<ul>
  <li>vyšší vek,</li>
  <li>vyšší index telesnej hmotnosti,</li>
  <li>začatie dialýzy na jednotke intenzívnej starostlivosti,</li>
  <li>polycystická choroba obličiek.</li>
</ul>

<p>Výkonnosť modelu bola:</p>

<ul>
  <li><strong>senzitivita 91,3 %</strong>,</li>
  <li><strong>správnosť (accuracy) 0,68</strong> (95 % IS 0,65–0,72),</li>
  <li><strong>plocha pod krivkou ROC 0,69 až 0,71</strong>.</li>
</ul>

<p>Autori uzavreli, že model má vysokú senzitivitu a je hodnotným nástrojom na skríning potenciálnych kandidátov.</p>

<p>Práca však obsahuje aj údaj, ktorý je z hľadiska praxe najdôležitejší: z <strong>391 pacientov uznaných za vhodných dostalo peritoneálnu dialýzu do šiestich mesiacov len 22,3 %</strong>.</p>

<h2>Prečo výhrada v liste dáva zmysel</h2>

<p>Emre Cankaya z Ankara Bilkent City Hospital publikoval k tejto práci list redakcii s názvom, ktorý zhrňuje jeho stanovisko: predikcia vhodnosti na peritoneálnu dialýzu <strong>vyžaduje validáciu a jasnejšiu prírastkovú hodnotu</strong>. Aj bez prístupu k plnému textu listu sa dá ukázať, na čom taká výhrada stojí.</p>

<h3>Rozlišovacia schopnosť je len mierna</h3>

<p>Plocha pod krivkou ROC 0,69 až 0,71 znamená, že model rozlíši náhodne vybranú dvojicu pacientov správne asi v 70 % prípadov. Pri hodnote 0,5 by išlo o hod mincou. Ide teda o výkonnosť, ktorá je merateľne lepšia než náhoda, ale ďaleko od spoľahlivosti potrebnej na rozhodovanie o jednotlivom pacientovi.</p>

<h3>Senzitivita 91,3 % bez špecificity nič nehovorí</h3>

<p>Vysoká senzitivita znie presvedčivo, no sama osebe je bezcenná — dosiahne ju aj model, ktorý označí za vhodných takmer všetkých. Pri správnosti 0,68 a takto vysokej senzitivite musí byť špecificita nízka. Model teda pravdepodobne <strong>zriedka prehliadne vhodného kandidáta, ale často označí za vhodného aj toho, kto ním nie je</strong>. Pre skríningový nástroj to nie je nutne chybné nastavenie, treba ho však takto pomenovať a otvorene uviesť aj špecificitu.</p>

<h3>Chýba externá validácia a kalibrácia</h3>

<p>Model vznikol v jednej provincii, v jednom systéme a v jednom časovom období. Bez overenia v inej populácii nie je známe, či jeho výkonnosť pretrvá. Odporúčania na hodnotenie prediktívnych modelov, zhrnuté vo vyhlásení TRIPOD, pritom vyžadujú nielen rozlišovaciu schopnosť, ale aj <strong>kalibráciu</strong> — teda zhodu medzi predpovedanou a skutočne pozorovanou pravdepodobnosťou. Model môže dobre zoraďovať pacientov podľa rizika a napriek tomu systematicky nadhodnocovať alebo podhodnocovať samotné pravdepodobnosti.</p>

<h3>Prírastková hodnota nebola preukázaná</h3>

<p>Kľúčová otázka nie je, či model funguje, ale <strong>či prináša niečo nad rámec toho, čo skúsený nefrológ vie aj bez neho</strong>. Prediktory, ktoré model identifikoval — vek, index telesnej hmotnosti, začatie na jednotke intenzívnej starostlivosti a polycystická choroba obličiek — patria presne k faktorom, ktoré klinik zvažuje rutinne. Ak model iba potvrdzuje existujúcu úvahu, jeho prínos pre rozhodovanie je blízky nule.</p>

<p>Na túto otázku odpovedá analýza rozhodovacích kriviek, ktorú zaviedli Andrew Vickers a Elena Elkin: hodnotí čistý klinický prínos modelu v porovnaní so stratégiami „liečiť všetkých“ a „neliečiť nikoho“ naprieč rozsahom prahových pravdepodobností. Bez takejto analýzy zostáva plocha pod krivkou ROC číslom, ktoré nehovorí nič o tom, či sa vďaka modelu rozhodneme lepšie.</p>

<h2>Zásadnejší problém: čo model vlastne predpovedá</h2>

<p>Nad rámec uvedených metodických výhrad stojí za pozornosť jedna vec, ktorá sa v diskusiách o prediktívnych modeloch prehliada.</p>

<p>Cieľovým ukazovateľom modelu nie je, či pacient peritoneálnu dialýzu <em>zvládne</em>, ako dlho na nej <em>zotrvá</em> alebo aká bude jeho <em>kvalita života</em>. Cieľovým ukazovateľom je, či bol <strong>uznaný za vhodného</strong> — teda výsledok posúdenia iným lekárom.</p>

<p>Model teda predpovedá rozhodnutie lekára, nie osud pacienta. Z toho vyplýva dôsledok, ktorý treba domyslieť: takýto model dokáže v najlepšom prípade <strong>verne reprodukovať existujúcu prax vrátane jej skreslení</strong>. Ak sa v danom prostredí systematicky podceňuje vhodnosť starších pacientov alebo pacientov s vyšším indexom telesnej hmotnosti, model sa túto zaujatosť naučí, vydá ju v číselnej podobe a dodá jej zdanie objektivity. Formalizácia predsudku nie je jeho odstránením.</p>

<p>Pre skutočné rozhodovanie by bolo potrebné predpovedať tvrdé ukazovatele — technické zlyhanie, peritonitídu, prechod na hemodialýzu, hospitalizácie, kvalitu života. To je podstatne náročnejšie, ale klinicky zmysluplné.</p>

<h2>Kde je skutočné úzke miesto</h2>

<p>Najviac hovoriaci údaj celej práce je ten, ktorý sa predikcie netýka: z pacientov uznaných za vhodných začalo peritoneálnu dialýzu do pol roka len <strong>niečo vyše pätiny</strong>.</p>

<p>To znamená, že hlavná strata nenastáva pri posudzovaní vhodnosti, ale <strong>medzi uznaním vhodnosti a skutočným začatím liečby</strong>. Dôvody sú organizačné a ľudské: čakanie na zavedenie katétra, kapacita zaškolenia, urgentný začiatok hemodialýzy skôr, než sa stihne rozhodnúť, obavy pacienta, chýbajúca podpora v domácnosti alebo jednoducho zotrvačnosť raz zavedenej liečby.</p>

<p>Presnejší model vhodnosti tieto prekážky neodstráni. Ide o klasickú situáciu, keď sa nástroj zameriava na krok, ktorý nie je limitujúci.</p>

<h2>Ako s takýmito modelmi zaobchádzať</h2>

<ol>
  <li><strong>Používať ich na vyhľadávanie, nie na vylučovanie.</strong> Model s vysokou senzitivitou je vhodný na to, aby upozornil na pacienta, o ktorom sa ako o kandidátovi neuvažovalo. Nie je vhodný na to, aby niekoho vyradil.</li>
  <li><strong>Nezamieňať neochotu a nepripravenosť za nevhodnosť.</strong> Časť prekážok je odstrániteľná — asistovaná peritoneálna dialýza, dlhšie zaškolenie, zapojenie rodiny, opakovaný rozhovor.</li>
  <li><strong>Sledovať vlastné výsledky.</strong> Ak sa model v centre používa, treba porovnávať jeho predpovede so skutočnosťou. Ide o najjednoduchšiu formu miestnej validácie.</li>
  <li><strong>Pýtať sa na prírastkovú hodnotu.</strong> Pri každom nástroji je namieste otázka, aké rozhodnutie by dopadlo inak, keby ho nebolo.</li>
  <li><strong>Nezabúdať na preferencie pacienta.</strong> Vhodnosť je predpokladom, nie dôvodom. Model, ktorý nepozná, čo pacient chce, nemôže rozhodnúť o modalite.</li>
</ol>

<h2>Záver</h2>

<p>Model kanadskej skupiny je poctivo urobenou prácou, ktorá pomenúva faktory spojené s posudzovaním vhodnosti na peritoneálnu dialýzu. Jeho rozlišovacia schopnosť je však len mierna, chýba externá validácia a nie je preukázané, že mení rozhodovanie k lepšiemu. Výhrada vyjadrená v liste redakcii je preto vecná.</p>

<p>Podstatnejšie je, čo z tejto práce vyplýva pre rozvoj peritoneálnej dialýzy. Ak sa vyše tri štvrtiny pacientov uznaných za vhodných k tejto liečbe nedostanú, problémom nie je nedostatočne presné posudzovanie vhodnosti. Problémom je cesta od rozhodnutia k liečbe — a tú nezlepší žiadny model, len organizácia starostlivosti.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=predialyzacna-edukacia-volba-peritonealnej-dialyzy">Predialyzačná edukácia a voľba peritoneálnej dialýzy</a>.</li>
  <li><a href="article.php?slug=neochota-zdielat-hodnoty-spolocne-rozhodovanie-krt">Keď pacient nechce hovoriť o svojich hodnotách</a> — spoločné rozhodovanie o modalite.</li>
  <li><a href="article.php?slug=umela-inteligencia-nefrologia-co-vieme-limity">Umelá inteligencia v nefrológii</a> — čo vieme a kde sú limity.</li>
  <li><a href="article.php?slug=udrzatelna-peritonealna-dialyza-pacienti-zelena-nefrologia">Udržateľná peritoneálna dialýza</a>.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Emre Cankaya.</strong> <em>Prediction of PD eligibility requires validation and clearer incremental value.</em> Peritoneal Dialysis International. 2026 Aug 3 (online ahead of print, list redakcii). doi: 10.1177/08968608261476561. <a href="https://pubmed.ncbi.nlm.nih.gov/42545037/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1177/08968608261476561" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Yang Yang, Helen H. Chen, Robert R. Quinn, Joel A. Dubin, Matthew J. Oliver.</strong> <em>Predictive models on patients' eligibility for peritoneal dialysis.</em> Peritoneal Dialysis International. 2026;46(2):115–123. doi: 10.1177/08968608251317463. <a href="https://pubmed.ncbi.nlm.nih.gov/40012364/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Gary S. Collins, Johannes B. Reitsma, Douglas G. Altman, Karel G. M. Moons.</strong> <em>Transparent Reporting of a multivariable prediction model for Individual Prognosis or Diagnosis (TRIPOD): the TRIPOD statement.</em> Annals of Internal Medicine. 2015;162(1):55–63. doi: 10.7326/M14-0697. <a href="https://pubmed.ncbi.nlm.nih.gov/25560714/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Andrew J. Vickers, Elena B. Elkin.</strong> <em>Decision curve analysis: a novel method for evaluating prediction models.</em> Medical Decision Making. 2006;26(6):565–574. doi: 10.1177/0272989X06295361. <a href="https://pubmed.ncbi.nlm.nih.gov/17099194/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Bibliografické údaje oboch príspevkov z <em>Peritoneal Dialysis International</em> boli overené v PubMed a Europe PMC. <strong>Plný text ani abstrakt listu Emreho Cankayu neboli dostupné</strong> — záznam v PubMed abstrakt neobsahuje a plný text je za platobnou bariérou vydavateľa. Z listu je preto prevzatá <strong>iba jeho téza vyjadrená v názve</strong> (potreba validácie a jasnejšej prírastkovej hodnoty); konkrétne argumenty autora tu nie sú citované ani rekonštruované. Číselné údaje pôvodnej práce — 598 účastníkov, Alberta 2016 – 2018, štyri významné prediktory, senzitivita 91,3 %, správnosť 0,68 (95 % IS 0,65 – 0,72), plocha pod krivkou ROC 0,69 – 0,71 a podiel 22,3 % z 391 vhodných pacientov — boli overené proti zneniu abstraktu. Metodický rozbor (výklad plochy pod krivkou ROC, vzťah senzitivity a špecificity, význam kalibrácie a prírastkovej hodnoty), poznámka o tom, že cieľovým ukazovateľom modelu je rozhodnutie lekára, a úvaha o skutočnom úzkom mieste sú <strong>vlastným odborným komentárom</strong> opretým o citované metodické práce.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_predikcia-vhodnosti-peritonealnej-dialyzy-validacia_article',
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
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
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
