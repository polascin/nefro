<?php

/**
 * add_serove-ketolatky-oblickove-udalosti-diabetes-2-typu_article.php
 * Odborný článok: sérové ketolátky a obličkové/kardiovaskulárne udalosti pri DM 2. typu.
 * Spracovaný zdroj: Shin SM, Lee J, Kim YE, et al. Diabetes Res Clin Pract. 2026;239:113476.
 * doi 10.1016/j.diabres.2026.113476 (PMID 42537913).
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
    'title'        => 'Sérové ketolátky a riziko obličkových udalostí pri diabete 2. typu: čo kohortová štúdia ukazuje a čo z nej vyvodiť nemožno',
    'slug'         => 'serove-ketolatky-oblickove-udalosti-diabetes-2-typu',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'V kórejskej kohorte 1 392 pacientov s diabetom 2. typu bez inzulínu a tiazolidíndiónov sa vyššie sérové ketolátky spájali s nižším rizikom obličkových udalostí. Ide o asociáciu, ktorej hlavným otáznikom je liečba inhibítormi SGLT2.',
    'content'      => <<<'HTML'
<p>Ketolátky sa v nefrológii dlho spomínali najmä v súvislosti s ketoacidózou. Posledné roky ich však posunuli aj do inej roly — ako možný ukazovateľ metabolického stavu, prípadne ako mediátor účinku inhibítorov SGLT2. Prospektívna kohortová štúdia z Kórey teraz sleduje, či cirkulujúce ketolátky súvisia s ďalším osudom obličiek u ambulantných pacientov s diabetom 2. typu. Výsledok je zaujímavý, no jeho interpretácia si vyžaduje väčšiu opatrnosť, než akú naznačuje záver samotnej práce.</p>

<h2>Dizajn a populácia</h2>

<p>Analýza zahrnula <strong>1 392 klinicky stabilných pacientov s diabetom 2. typu</strong>, ktorí <strong>neboli liečení inzulínom ani tiazolidíndiónmi</strong>. Sérová koncentrácia celkových ketolátok sa merala v stabilných ambulantných podmienkach a pacienti sa rozdelili do tercilov:</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Rozdelenie pacientov podľa koncentrácie celkových sérových ketolátok" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Tercil</th>
        <th scope="col">Koncentrácia celkových ketolátok</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Najnižší</th>
        <td>0,08 – 92,3 µmol/l</td>
      </tr>
      <tr>
        <th scope="row">Stredný</th>
        <td>92,7 – 170,8 µmol/l</td>
      </tr>
      <tr>
        <th scope="row">Najvyšší</th>
        <td>171,0 – 1 629,6 µmol/l</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Ide teda o rozpätie mierne zvýšených hodnôt, nie o ketoacidózu. Obličkové ukazovatele zahŕňali novovzniknutú makroalbuminúriu, pokles eGFR o ≥ 40 % a zlyhanie obličiek vyžadujúce náhradu funkcie. Kardiovaskulárne ukazovatele zahŕňali infarkt myokardu, revaskularizáciu, ischemickú cievnu mozgovú príhodu, hospitalizáciu pre srdcové zlyhávanie a kardiovaskulárnu smrť. Medián sledovania bol <strong>23,2 mesiaca</strong>; zaznamenalo sa <strong>158 obličkových a 64 kardiovaskulárnych udalostí</strong>.</p>

<h2>Výsledky</h2>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Asociácia najvyššieho tercilu ketolátok oproti najnižšiemu s obličkovými ukazovateľmi" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ (najvyšší vs. najnižší tercil)</th>
        <th scope="col">Upravený pomer rizík (aHR)</th>
        <th scope="col">95 % IS</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Pokles eGFR o ≥ 40 %</th>
        <td>0,46</td>
        <td>0,26 – 0,84</td>
      </tr>
      <tr>
        <th scope="row">Zložený obličkový ukazovateľ</th>
        <td>0,63</td>
        <td>0,41 – 0,98</td>
      </tr>
      <tr>
        <th scope="row">Novovzniknutá CKD (podskupina s východiskovou eGFR ≥ 60 ml/min/1,73 m²)</th>
        <td>0,50</td>
        <td>0,31 – 0,79</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Kardiovaskulárne ukazovatele vykázali priaznivý smer bez štatistickej významnosti — pri 64 udalostiach je to očakávateľné a nemožno z toho vyvodzovať ani prítomnosť, ani neprítomnosť účinku.</p>

<h2>Kde je hlavný problém interpretácie: inhibítory SGLT2</h2>

<p>Toto je bod, ktorý rozhoduje o tom, ako sa má štúdia čítať. <strong>Inhibítory SGLT2 zvyšujú koncentráciu ketolátok</strong> — ide o dobre opísaný metabolický efekt tejto triedy. Súčasne ide o jedinú liekovú triedu v štúdii, pri ktorej je nefroprotektívny účinok dokázaný randomizovanými štúdiami.</p>

<p>Ak teda pacienti v najvyššom tercile ketolátok užívali častejšie inhibítor SGLT2, potom pozorovaná asociácia „vyššie ketolátky — menej obličkových udalostí“ môže z podstatnej časti odrážať jednoducho to, že títo pacienti boli lepšie liečení. Ketolátky by v takom prípade neboli mediátorom ochrany, ale <strong>ukazovateľom expozície účinnému lieku</strong>. Rozlíšiť tieto dve možnosti pozorovacím dizajnom s jednorazovým meraním expozície nemožno; vyžadovalo by si to prinajmenšom stratifikáciu podľa užívania inhibítora SGLT2, ideálne mediačnú analýzu na randomizovaných dátach.</p>

<p>Z dostupného abstraktu nevyplýva, ako sa s touto skutočnosťou naložilo. Kľúčové slová práce však inhibítor SGLT2 explicitne uvádzajú, takže autori si problém zjavne uvedomovali. Bez plného textu ide o otvorenú otázku, ktorá by mala byť pri čítaní práce prvá.</p>

<h2>Výhrada k formulácii záveru</h2>

<p>Autori v závere abstraktu uvádzajú, že zistenia „podporujú možnú úlohu ketolátok ako mediátorov obličkového rizika“. Táto formulácia je silnejšia, než čo dizajn unesie. Mediácia je kauzálny pojem: predpokladá, že expozícia leží na príčinnej dráhe medzi niečím a výsledkom. Prospektívna kohorta s <strong>jednorazovým meraním expozície</strong>, bez randomizácie a bez publikovanej formálnej mediačnej analýzy, dokáže preukázať asociáciu — nie mediáciu.</p>

<p>Korektnejšie čítanie znie: mierne zvýšené sérové ketolátky boli v tejto populácii <strong>prognosticky</strong> spojené s nižším rizikom obličkových udalostí. Či ide o príčinu, o dôsledok inej priaznivej okolnosti, alebo o marker liečby, štúdia nerozhoduje.</p>

<h2>Ďalšie obmedzenia</h2>

<ul>
  <li><strong>Jednorazové meranie expozície.</strong> Koncentrácia ketolátok kolíše podľa príjmu potravy, odstupu od posledného jedla, telesnej záťaže a metabolického stavu. Jedno meranie zaraďuje pacienta do tercilu s neznámou stabilitou v čase.</li>
  <li><strong>Vylúčenie pacientov na inzulíne a tiazolidíndiónoch.</strong> Ide o selekciu smerom k menej pokročilému diabetu; zistenia sa nedajú prenášať na pacientov liečených inzulínom, ktorí tvoria významnú časť nefrologickej ambulancie.</li>
  <li><strong>Krátke sledovanie.</strong> Medián 23,2 mesiaca je pre obličkové ukazovatele krátky. Pokles eGFR o ≥ 40 % zachytený v takomto okne môže byť u časti pacientov ovplyvnený aj hemodynamickými zmenami po začatí liečby, nie len skutočnou stratou funkcie.</li>
  <li><strong>Zvyškové zavádzajúce faktory.</strong> Popri liečbe inhibítorom SGLT2 prichádzajú do úvahy aj rozdiely vo veku, východiskovej funkcii obličiek, telesnej hmotnosti a stravovaní. Bez plného textu nie je zrejmé, ktoré z nich boli v modeloch zohľadnené.</li>
</ul>

<h2>Čo z toho vyplýva pre prax</h2>

<p>Pre klinické rozhodovanie z práce zatiaľ nevyplýva nič, čo by malo meniť postup. Konkrétne:</p>

<ul>
  <li>Ketolátky <strong>nie sú</strong> validovaným nástrojom na stratifikáciu obličkového rizika a ich rutinné vyšetrovanie na tento účel nie je odôvodnené.</li>
  <li>Zvyšovanie ketolátok <strong>nie je</strong> liečebným cieľom; žiadna štúdia nepreukázala, že ich cielené zvýšenie zlepší obličkové výsledky.</li>
  <li>Výsledok <strong>nepodporuje</strong> odporúčanie ketogénnej diéty pacientom s CKD; nutričné riziká pri pokročilej chorobe obličiek sú vlastnou samostatnou témou.</li>
  <li>Rozumným praktickým čítaním je opak: pripomienka, že liečba, ktorá ketolátky zvyšuje ako vedľajší metabolický efekt — teda inhibítor SGLT2 — má u vhodných pacientov dokázaný nefroprotektívny prínos a mala by byť nasadená.</li>
</ul>

<h2>Záver</h2>

<p>V prospektívnej kohorte pacientov s diabetom 2. typu bez inzulínu a tiazolidíndiónov sa mierne zvýšené sérové ketolátky spájali s nižším rizikom zloženého obličkového ukazovateľa, najmä prostredníctvom nižšieho rizika poklesu eGFR o ≥ 40 %. Zistenie je hypotézotvorné. Kým sa nevylúči, že za asociáciou nestojí jednoducho liečba inhibítorom SGLT2, je predčasné hovoriť o ketolátkach ako o mediátoroch ochrany obličiek — a rovnako predčasné je zaviesť ich do klinickej rozvahy.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=ketoacidoza-nefrologicka-prax-hladovanie-euglykemicka-dka">Ketoacidóza v nefrologickej praxi: od hladovania po euglykemickú diabetickú ketoacidózu</a></li>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">Chronická choroba obličiek pri diabete: včasný skríning a vrstvená kardiorenálna liečba</a></li>
  <li><a href="article.php?slug=osmolalita-mocu-nalacno-riziko-progresie-dm2">Osmolalita moču nalačno a riziko progresie ochorenia obličiek u pacientov s diabetom 2. typu</a></li>
  <li><a href="article.php?slug=vyber-sglt2-glp1-dualne-agonisty-kardiorenalne-riziko">Výber a kombinovanie inhibítorov SGLT2, agonistov GLP-1 a duálnych agonistov pri diabete 2. typu</a></li>
</ul>

<hr>

<h2>Odborné zdroje</h2>

<p><small><em><strong>Spracovaný zdroj:</strong> Shin SM, Lee J, Kim YE, Kim JA, Kim KJ, Kim KJ, Kim HY, Kim SG, Kim NH. Serum ketone body levels and risk of incident kidney and cardiovascular events among patients with type 2 diabetes: a prospective cohort study. <em>Diabetes Research and Clinical Practice</em>. 2026;239:113476. doi: <a href="https://doi.org/10.1016/j.diabres.2026.113476" target="_blank" rel="noopener noreferrer">10.1016/j.diabres.2026.113476</a>. PMID 42537913. <a href="https://pubmed.ncbi.nlm.nih.gov/42537913/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje, úplný autorský zoznam, veľkosť kohorty, hranice tercilov, dĺžka sledovania, počty udalostí a všetky uvedené pomery rizík boli overené 28. augusta 2026 cez PubMed zo štruktúrovaného abstraktu spracovanej práce. Plný text nemá otvorenú verziu. Údaje, ktoré v abstrakte nie sú uvedené — priemerný vek, zastúpenie žien, podmienky odberu, použitá analytická metóda, prahová hodnota pre makroalbuminúriu, tvar vzťahu medzi koncentráciou ketolátok a rizikom a zoznam premenných v modeloch — sa v článku zámerne neuvádzajú. Metodické výhrady vrátane úvahy o inhibítoroch SGLT2 nie sú prevzaté od autorov, ale odvodené z dostupného opisu metodiky.</em></small></p>

<p><small><em>Text má odborný informačný charakter a nenahrádza individuálne klinické rozhodovanie ani platné odporúčania pre liečbu diabetu a chronickej choroby obličiek.</em></small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    // Publikované v dávke šiestich článkov naraz — newsletterové avízo sa zámerne
    // neposiela, aby odberatelia nedostali šesť samostatných e-mailov v tej istej chvíli.
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_serove_ketolatky_oblickove_udalosti_dm2',
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
