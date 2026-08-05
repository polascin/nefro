<?php

/**
 * add_krce-kostroveho-svalstva-dialyza-prevalencia-metaanalyza_article.php
 * Prevalencia krcov kostroveho svalstva u dialyzovanych pacientov - metaanalyza.
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
    'title'        => 'Kŕče kostrového svalstva pri dialýze: globálna prevalencia 55 % a čo s tým v praxi',
    'slug'         => 'krce-kostroveho-svalstva-dialyza-prevalencia-metaanalyza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Metaanalýza 94 štúdií s 32 223 pacientmi z 36 krajín zistila kŕče u 55 % dialyzovaných pacientov a intradialytické kŕče u 33 %. Široké predikčné intervaly však hovoria rovnako veľa ako samotné čísla — meranie tohto symptómu nie je zjednotené.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Svalové kŕče patria medzi symptómy, ktoré pacienti na dialýze uvádzajú medzi najhoršími, no ktoré sa v ambulancii systematicky nezisťujú. Prvá globálna metaanalýza ukazuje, že sa týkajú viac než polovice pacientov. Jej najpoučnejším nálezom však nie je samotné číslo, ale to, aké je neisté.</em></p>

<p>Kŕče kostrového svalstva sú pri dialýze dlho známym problémom, ktorý sa napriek tomu ocitá na okraji pozornosti. Nemajú vlastný diagnostický kód, nevstupujú do ukazovateľov kvality a v porovnaní s anémiou či fosfátmi nemajú vlastný liečebný algoritmus. Pritom môžu viesť k predčasnému ukončeniu dialyzačnej procedúry, k nedostatočnému odstráneniu tekutín a v konečnom dôsledku k horšej kontrole objemu — teda k dôsledkom, ktoré už tvrdé ukazovatele ovplyvňujú.</p>

<h2>Čo metaanalýza zistila</h2>

<p>Seda Babroudi, Marcelle Tuttle a Eduardo K. Lacson jr. prehľadali štyri databázy do 30. septembra 2025. Zaradili observačné a nerandomizované experimentálne štúdie u <strong>nehospitalizovaných</strong> dialyzovaných pacientov publikované v angličtine; vylúčili kazuistiky, randomizované štúdie, systematické prehľady a metaanalýzy. Riziko skreslenia hodnotili Newcastle-Ottawskou škálou a prevalencie zlučovali metaanalýzou s náhodnými efektmi.</p>

<p>Do syntézy vstúpilo <strong>94 štúdií s 32 223 pacientmi z 36 krajín na piatich kontinentoch</strong>. Väčšina štúdií (54, teda 57 %) sa týkala hemodialýzy a 16 štúdií uvádzalo prevalenciu špecificky pre intradialytické kŕče.</p>

<p>Výsledky:</p>

<ul>
  <li><strong>Celková zlúčená prevalencia kŕčov: 55 %</strong> (95 % IS 50–59 %, 95 % predikčný interval 20–86 %).</li>
  <li><strong>Zlúčená prevalencia intradialytických kŕčov: 33 %</strong> (95 % IS 22–47 %, 95 % predikčný interval 4–87 %).</li>
</ul>

<p>Prevalencia bola vyššia pri hemodialýze než pri peritoneálnej dialýze, u nových (incidentných) pacientov než u prevalentných a pri štvortýždňovom období spomínania než pri jednotýždňovom. Medzi štúdiami bola významná heterogenita a väčšina štúdií (50, teda 53 %) mala stredné riziko skreslenia.</p>

<h2>Prečo je predikčný interval dôležitejší než bodový odhad</h2>

<p>Číslo 55 % sa dobre cituje, ale samo osebe zavádza. Rozdiel medzi intervalom spoľahlivosti a predikčným intervalom je tu kľúčový:</p>

<ul>
  <li><strong>Interval spoľahlivosti (50–59 %)</strong> hovorí, ako presne poznáme <em>priemer</em> naprieč štúdiami. Je úzky, lebo štúdií je veľa.</li>
  <li><strong>Predikčný interval (20–86 %)</strong> hovorí, akú prevalenciu možno očakávať v <em>ďalšej</em> štúdii alebo v konkrétnom centre. Je veľmi široký.</li>
</ul>

<p>Pri intradialytických kŕčoch je rozptyl ešte výraznejší — predikčný interval 4 až 87 % prakticky znamená, že z tejto metaanalýzy sa o očakávanej prevalencii vo vlastnom centre nedá vyvodiť takmer nič.</p>

<p>Nejde o slabinu autorov, ale o <strong>poctivo priznaný stav dôkazov</strong>. Rozptyl s najväčšou pravdepodobnosťou neodráža skutočné biologické rozdiely medzi krajinami, ale rozdiely v tom, ako sa kŕče definujú a zisťujú.</p>

<h2>Metodika merania určuje výsledok</h2>

<p>Nález, že štvortýždňové obdobie spomínania dáva vyššiu prevalenciu než jednotýždňové, je zdanlivo triviálny, no má ďalekosiahle dôsledky. Znamená, že <strong>podstatná časť rozdielov medzi štúdiami vzniká v dotazníku, nie v pacientovi</strong>.</p>

<p>Ovplyvňujú to prinajmenšom štyri rozhodnutia:</p>

<ol>
  <li><strong>Časové okno.</strong> Za posledný týždeň, mesiac, alebo „vôbec niekedy“?</li>
  <li><strong>Vzťah k procedúre.</strong> Intradialytické kŕče alebo kŕče kedykoľvek, vrátane nočných?</li>
  <li><strong>Prah závažnosti.</strong> Akýkoľvek kŕč, alebo len taký, ktorý pacienta obťažuje?</li>
  <li><strong>Spôsob zisťovania.</strong> Aktívna otázka v dotazníku, alebo spontánny záznam v dokumentácii? Rozdiel medzi nimi býva niekoľkonásobný.</li>
</ol>

<p>Zistenie, že incidentní pacienti majú kŕče častejšie než prevalentní, si zaslúži opatrný výklad. Môže ísť o adaptáciu — po niekoľkých mesiacoch sa upraví suchá hmotnosť aj ultrafiltračný režim. Rovnako však môže ísť o <strong>skreslenie prežívaním a selekciou</strong>: pacienti, ktorí kŕče znášali najhoršie, mohli prejsť na inú modalitu alebo liečbu ukončiť.</p>

<h2>Prečo kŕče pri dialýze vznikajú</h2>

<p>Metaanalýza sa mechanizmami nezaoberá, pre prax však stojí za to ich pripomenúť. Intradialytické kŕče sa najčastejšie spájajú s:</p>

<ul>
  <li><strong>rýchlou alebo nadmernou ultrafiltráciou</strong> a poklesom pod skutočnú suchú hmotnosť — ide o najčastejšiu a zároveň najlepšie ovplyvniteľnú príčinu;</li>
  <li><strong>intradialytickou hypotenziou</strong> a poklesom perfúzie svalu;</li>
  <li><strong>poruchami elektrolytov</strong> — najmä rýchlymi zmenami sodíka, ako aj hypomagneziémiou, hypokalciémiou a hypokaliémiou;</li>
  <li>zmenami osmolality a presunmi tekutín medzi kompartmentmi.</li>
</ul>

<p>Kŕče mimo dialýzy majú širšiu diferenciálnu diagnostiku, do ktorej patrí periférna neuropatia, lieky (najmä diuretiká a statíny), hypotyreóza, deficit vitamínu D a ochorenie periférnych tepien.</p>

<h2>Čo s tým v praxi</h2>

<p>Postupnosť krokov, ktorá vychádza z uvedených mechanizmov:</p>

<ol>
  <li><strong>Aktívne sa pýtať.</strong> Ak sa symptóm vyskytuje u polovice pacientov a v dokumentácii ho má zlomok z nich, problém nie je v prevalencii, ale v tom, že sa nezisťuje. Otázka má rozlíšiť kŕče počas procedúry a mimo nej — spúšťače aj riešenia sa líšia.</li>
  <li><strong>Prehodnotiť suchú hmotnosť.</strong> Opakované kŕče v druhej polovici procedúry sú najčastejšie znakom nastavenia príliš nízko. Pomôcť môže bioimpedancia alebo ultrasonografické hodnotenie dolnej dutej žily.</li>
  <li><strong>Znížiť ultrafiltračnú rýchlosť.</strong> Predĺženie procedúry, pridanie štvrtej dialýzy v týždni alebo dôsledná práca s príjmom soli sú účinnejšie než akákoľvek farmakologická liečba.</li>
  <li><strong>Skontrolovať elektrolyty</strong> vrátane horčíka, ktorý sa rutinne nestanovuje a ktorého deficit je pri dlhodobej dialýze reálny.</li>
  <li><strong>Zvážiť ochladenie dialyzátu</strong> tam, kde kŕče sprevádza intradialytická hypotenzia.</li>
  <li><strong>Nezabudnúť na naťahovanie a pohyb.</strong> Ide o lacné, bezpečné opatrenia, ktoré pacient zvládne sám.</li>
</ol>

<h2>Bezpečnostná poznámka: chinín nie</h2>

<p>Chinín sa pri nočných kŕčoch dlhé roky používal mimo registrovanej indikácie. Americká lieková agentúra pred týmto použitím v roku 2010 <strong>výslovne varovala</strong> pre riziko závažných hematologických reakcií, najmä trombocytopénie, hemolýzy a úmrtí. Pomer prínosu a rizika je pri symptóme, akým sú kŕče, nepriaznivý — a u dialyzovaného pacienta s už zvýšeným rizikom krvácania to platí dvojnásobne.</p>

<p>Aj pri ostatných liekoch skúšaných v tejto indikácii — levokarnitíne, vitamíne E, gabapentíne — je dôkazová základňa slabá a opiera sa o malé štúdie. Farmakologická liečba by preto mala nasledovať až po vyčerpaní úprav dialyzačného režimu, nie ich nahrádzať.</p>

<h2>Limity</h2>

<ul>
  <li>Ide o syntézu <strong>observačných a nerandomizovaných</strong> štúdií — prevalencia sa nedá interpretovať príčinne a metaanalýza neodpovedá na otázku, čo kŕče spôsobuje ani čo na ne zaberá.</li>
  <li><strong>Významná heterogenita</strong> a stredné riziko skreslenia u vyše polovice štúdií znižujú váhu bodových odhadov.</li>
  <li>Zaradené boli len práce publikované <strong>v angličtine</strong>, čo prináša jazykové a publikačné skreslenie.</li>
  <li>Vylúčenie hospitalizovaných pacientov je metodicky opodstatnené, ale znamená, že najzávažnejšie prípady v odhade chýbajú.</li>
  <li>Kŕče sú <strong>výlučne sebahlásené</strong> — objektívny ukazovateľ neexistuje.</li>
</ul>

<h2>Záver</h2>

<p>Metaanalýza dokladá, že svalové kŕče nie sú okrajovým problémom: postihujú približne <strong>55 % dialyzovaných pacientov</strong> a približne <strong>tretina</strong> ich zažíva priamo počas procedúry. Už samotné toto zistenie je dôvodom, aby sa kŕče zisťovali systematicky, a nie náhodne, keď ich pacient spomenie.</p>

<p>Druhé posolstvo je metodické a rovnako dôležité. Predikčné intervaly 20–86 % a 4–87 % ukazujú, že <strong>tento symptóm zatiaľ nevieme jednotne merať</strong>. Kým sa nezhodneme na definícii, časovom okne a spôsobe zisťovania, budú sa výsledky štúdií naďalej rozchádzať a intervenčné štúdie budú mať slabý základ. Prvým krokom k lepšej liečbe kŕčov teda nie je nový liek, ale jednotný spôsob, ako sa na ne pýtať.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=dennik-semafor-objemovy-manazment-hemodialyza-rct">Denník semafor a objemový manažment pri hemodialýze</a>.</li>
  <li><a href="article.php?slug=umela-inteligencia-sucha-hmotnost-hemodialyza">Umelá inteligencia a určovanie suchej hmotnosti</a>.</li>
  <li><a href="article.php?slug=dialyzacny-dysekvilibracny-syndrom-zaciatok-hemodialyzy">Dialyzačný dysekvilibračný syndróm</a> — ďalšia komplikácia začiatku hemodialýzy.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Seda Babroudi, Marcelle Tuttle, Eduardo K. Lacson Jr.</strong> <em>Skeletal Muscle Cramp Prevalence among Patients Receiving Dialysis: A Global Systematic Review and Meta-Analysis.</em> Clinical Journal of the American Society of Nephrology. 2026 Aug 3 (online ahead of print). doi: 10.2215/CJN.0000001169. <a href="https://pubmed.ncbi.nlm.nih.gov/42545740/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.2215/CJN.0000001169" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>U.S. Food and Drug Administration.</strong> <em>FDA Drug Safety Communication: New risk management plan and patient Medication Guide for Qualaquin (quinine sulfate).</em> 8. júla 2010. <a href="https://www.fda.gov/drugs/postmarket-drug-safety-information-patients-and-providers/fda-drug-safety-communication-new-risk-management-plan-and-patient-medication-guide-qualaquin-quinine" target="_blank" rel="noopener noreferrer">FDA</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Všetky číselné údaje metaanalýzy — 94 štúdií, 32 223 pacientov, 36 krajín na piatich kontinentoch, 54 štúdií (57 %) v hemodialýze, 16 štúdií s intradialytickými kŕčmi, celková prevalencia 55 % (95 % IS 50–59 %, 95 % PI 20–86 %), intradialytická prevalencia 33 % (95 % IS 22–47 %, 95 % PI 4–87 %), podskupinové rozdiely podľa modality, incidencie a dĺžky obdobia spomínania, ako aj 50 štúdií (53 %) so stredným rizikom skreslenia — boli overené proti doslovnému zneniu abstraktu v zázname PubMed. Plný text práce je za platobnou bariérou vydavateľa a nebol sprístupnený. Časť o mechanizmoch vzniku kŕčov, praktický postup a bezpečnostná poznámka o chiníne <strong>nepochádzajú z tejto metaanalýzy</strong> — ide o vlastné odborné spracovanie opreté o etablované poznatky a o citované varovanie liekovej agentúry.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_krce-kostroveho-svalstva-dialyza-prevalencia-metaanalyza_article',
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
