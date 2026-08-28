<?php

/**
 * add_gutmaxxing-rigidny-dietny-protokol-nefrologia_article.php
 * Odborný článok: „gutmaxxing“ ako rigidný diétny protokol a jeho nefrologické
 * súvislosti. Východiskový materiál: Medscape (2026); odborné prahy overené
 * podľa KDIGO 2024.
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
    'title'        => '„Gutmaxxing“: keď sa snaha o zdravé črevo zmení na rigidný protokol a čo to znamená v nefrologickej ambulancii',
    'slug'         => 'gutmaxxing-rigidny-dietny-protokol-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Online trend „gutmaxxing“ spája vysoký príjem bielkovín, vlákninové a suplementačné režimy a vyraďovanie skupín potravín. Pre pacienta s chronickou chorobou obličiek sú pritom bežne odporúčané cieľové hodnoty nevhodné až rizikové.',
    'content'      => <<<'HTML'
<p>Pojmom „gutmaxxing“ sa v online komunitách označuje snaha o maximálne „optimalizované“ trávenie: vysoký príjem vlákniny a bielkovín, sledovanie makroživín, kombinácie výživových doplnkov, opakované „detoxikačné“ a „očistné“ cykly a vyraďovanie celých skupín potravín. Je súčasťou širšieho javu, ktorý spája sebazlepšovanie s číselnými cieľmi. Z pohľadu ambulancie nejde v prvom rade o to, čo pacient je — ale o to, <strong>ako prísne dodržiava pravidlá, ktoré si stanovil</strong>. A pre pacienta s chronickou chorobou obličiek (CKD) sú tieto pravidlá spravidla prevzaté z odporúčaní, ktoré preňho neplatia.</p>

<h2>Čo taký protokol zvyčajne obsahuje</h2>

<ul>
  <li>Číselné ciele pre bielkoviny a vlákninu, často prevzaté z fitness obsahu.</li>
  <li>Viacero výživových doplnkov naraz — probiotiká, vlákninové prípravky, proteínové koncentráty, kreatín, elektrolytové zmesi, bylinné prípravky.</li>
  <li>Vyraďovanie skupín potravín (lepok, mliečne výrobky, niektoré rastlinné oleje, väčšina ovocia) bez preukázanej intolerancie alebo alergie.</li>
  <li>Opakované „očistné“ režimy a preplachy.</li>
  <li>Denné vykazovanie a kontrola dodržiavania pravidiel.</li>
</ul>

<h2>Prečo je to nefrologická téma</h2>

<p>Nefrológ sa s týmto javom stretáva v troch podobách. Prvou je pacient s CKD, ktorý si našiel „zdravý“ režim a nepovažuje ho za niečo, čo by mal v ambulancii spomenúť. Druhou je mladý pacient bez známeho ochorenia obličiek, ktorý prichádza s náhodne zisteným zvýšeným kreatinínom. Treťou je pacient, u ktorého sa za nutričným protokolom skrýva porucha príjmu potravy.</p>

<h3>Cieľové hodnoty pre bežnú populáciu nie sú cieľovými hodnotami pri CKD</h3>

<p>Toto je najdôležitejšia praktická informácia celého článku. Hodnoty, ktoré v populárnych prehľadoch figurujú ako rozumné, sú pri CKD nad odporúčaným stropom:</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Porovnanie odporúčaní pre príjem bielkovín v bežnej populácii a pri chronickej chorobe obličiek" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Situácia</th>
        <th scope="col">Príjem bielkovín</th>
        <th scope="col">Poznámka</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Aktívny dospelý bez ochorenia obličiek</th>
        <td>Bežne uvádzané rozpätie približne 1,2 – 1,6 g/kg/deň</td>
        <td>Populárne zdroje zároveň odrádzajú od dlhodobého prekračovania 2 g/kg/deň.</td>
      </tr>
      <tr>
        <th scope="row">CKD G3 – G5 bez dialýzy</th>
        <td><strong>0,8 g/kg/deň</strong></td>
        <td>Odporúčanie KDIGO 2024; pri riziku progresie sa <strong>neodporúča prekračovať 1,3 g/kg/deň</strong>.</td>
      </tr>
      <tr>
        <th scope="row">Pacient na dialýze</th>
        <td>Vyšší príjem než pri CKD bez dialýzy</td>
        <td>Riziko je opačné — podvýživa a úbytok svalovej hmoty. Cieľ určuje nefrológ spolu s nutričným terapeutom.</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Rozdiel je zásadný. Cieľ 1,6 g/kg/deň prevzatý z fitness obsahu leží u pacienta s CKD nad hranicou, ktorú KDIGO neodporúča prekračovať. U 80-kilogramového pacienta ide o rozdiel medzi približne 64 g a 128 g bielkovín denne. Podrobnejšie sa touto otázkou zaoberá samostatný článok o mýtoch influencerov, na ktorý odkazujeme nižšie.</p>

<h3>Doplnky výživy a minerálový profil</h3>

<p>Pri CKD platí, že „prírodné“ nie je synonymom „bezpečné“. Praktické riziká kombinovaných suplementačných režimov:</p>

<ul>
  <li><strong>Draslík.</strong> Rastlinné proteínové zmesi, zeleninové koncentráty a elektrolytové prípravky môžu obsahovať významné množstvo draslíka bez toho, aby to bolo zjavné z obalu.</li>
  <li><strong>Fosfor.</strong> Fosforečnanové aditíva v spracovaných „proteínových“ výrobkoch sa vstrebávajú podstatne lepšie než fosfor viazaný v prirodzených potravinách.</li>
  <li><strong>Tekutiny a objem.</strong> Vlákninové prípravky vyžadujú dostatočný príjem tekutín, ktorý je pri pokročilej CKD alebo pri srdcovom zlyhávaní obmedzený. Naopak „očistné“ režimy môžu viesť k stratám tekutín a k prerenálnemu poškodeniu.</li>
  <li><strong>Bylinné prípravky.</strong> Časť z nich je nefrotoxická alebo vstupuje do liekových interakcií; zloženie výživových doplnkov nepodlieha rovnakej kontrole ako zloženie liekov.</li>
</ul>

<h3>Interpretácia kreatinínu</h3>

<p>Vysoký príjem bielkovín, doplnky s kreatínom a vyšší podiel svalovej hmoty zvyšujú koncentráciu kreatinínu bez toho, aby klesla skutočná filtrácia. Pri pacientovi s takýmto režimom je preto pred záverom o „zhoršení funkcie obličiek“ namieste doplniť cystatín C, prípadne albuminúriu, a odber zopakovať po vysadení doplnkov.</p>

<h2>Kedy ide už o poruchu, nie o disciplínu</h2>

<p>Hranica medzi starostlivosťou o zdravie a patologickým vzorcom nie je v obsahu diéty, ale v jej rigidite a v tom, čo sa stane pri jej porušení. Varovné signály:</p>

<ul>
  <li>výrazná úzkosť, vina alebo pocit zlyhania pri odchýlke od protokolu,</li>
  <li>vyhýbanie sa spoločným jedlám, cestovaniu alebo rodinným udalostiam kvôli pravidlám,</li>
  <li>postupné rozširovanie zoznamu zakázaných potravín bez klinického dôvodu,</li>
  <li>opakované kontrolné správanie — váženie, fotografovanie, zapisovanie, vyhľadávanie zloženia,</li>
  <li>neúmyselné chudnutie, únava, výpadok menštruácie, znížená výkonnosť,</li>
  <li>presvedčenie, ktoré odoláva vysvetleniu a opiera sa o obsah zo sociálnych sietí.</li>
</ul>

<p>Poznámka k terminológii: pojem „ortorexia“ sa v tejto súvislosti používa často, <strong>nejde však o samostatnú diagnostickú jednotku v DSM-5</strong>. Klinicky významné je to, či sú prítomné kritériá poruchy príjmu potravy — najmä vyhýbavo-reštriktívnej poruchy príjmu potravy — alebo obsedantno-kompulzívneho okruhu. Pri podozrení patrí pacient k psychiatrovi alebo klinickému psychológovi, nie k ďalšej nutričnej úprave.</p>

<h2>Praktický postup v ambulancii</h2>

<ol>
  <li><strong>Pýtať sa cielene.</strong> Otázka „dodržiavate nejakú diétu?“ často nestačí. Konkrétnejšie: „Máte nejaké pravidlá, čo môžete a čo nemôžete jesť? Čo sa stane, keď ich nedodržíte?“</li>
  <li><strong>Vypísať všetky doplnky.</strong> Vrátane proteínových práškov, elektrolytových zmesí, bylinných čajov a „očistných“ prípravkov. Pacienti ich spravidla neuvádzajú medzi liekmi.</li>
  <li><strong>Prepočítať skutočný príjem bielkovín</strong> na kilogram telesnej hmotnosti a porovnať ho s cieľom primeraným štádiu CKD, nie s cieľom z internetu.</li>
  <li><strong>Zvážiť laboratórne vyšetrenie</strong> podľa klinickej situácie: kálium, fosfor, vápnik, bikarbonát, kreatinín s cystatínom C, albuminúria, prípadne parametre nutričného stavu.</li>
  <li><strong>Nezakazovať plošne.</strong> Zákaz bez vysvetlenia motivovaného pacienta spravidla nezastaví — len ho prestane o režime informovať. Účinnejšie je ponúknuť konkrétny, číselne vyjadrený cieľ prispôsobený jeho štádiu CKD.</li>
  <li><strong>Vlákninu preferovať z potravy.</strong> Pri CKD však treba zohľadniť obsah draslíka v jednotlivých zdrojoch a prípadné obmedzenie príjmu tekutín.</li>
</ol>

<h2>Čo z tejto témy netreba preháňať</h2>

<p>Nejde o doložený nefrologický rizikový faktor s vlastnou epidemiológiou. Neexistujú údaje o tom, koľko pacientov s CKD takýto režim dodržiava, ani štúdie o jeho vplyve na progresiu ochorenia obličiek. Tvrdiť, že „gutmaxxing poškodzuje obličky“, by bolo rovnakým typom nepodloženého zjednodušenia, aké sa vyčíta samotnému trendu. Doložené je niečo iné a skromnejšie: <strong>pri CKD sú vysoký príjem bielkovín, nekontrolované doplnky a očistné režimy rizikové</strong>, a rigidný protokol prevzatý zo sociálnych sietí je spoľahlivá cesta ku všetkým trom naraz.</p>

<h2>Záver</h2>

<p>„Gutmaxxing“ je príklad toho, ako sa zdravotná motivácia mení na číselný protokol. Pre nefrológa z toho vyplývajú dve úlohy: preložiť cieľové hodnoty do podoby platnej pre dané štádium CKD — najmä pri bielkovinách, kde sa bežne odporúčané rozpätie s odporúčaním KDIGO míňa — a rozpoznať, kedy už za protokolom nestojí disciplína, ale porucha, ktorá si vyžaduje inú než nutričnú intervenciu.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=strava-a-zdravie-creva-myty-influencerov-ckd">Strava a zdravie čreva podľa influencerov: kde vznikajú najčastejšie chyby</a></li>
  <li><a href="article.php?slug=protein-kreatin-uz-nie-su-len-fitness-tema-nefrologia">Proteín a kreatín už nie sú výhradne „fitness téma“ a čo z toho plynie pre nefrológiu</a></li>
  <li><a href="article.php?slug=mierne-obmedzenie-bielkovin-ckd-prognoza">Mierne obmedzenie bielkovín môže pri chronickej chorobe obličiek zlepšiť prognózu</a></li>
  <li><a href="article.php?slug=kreatin-ochorenia-obliciek-bezpecnost-benefit">Kreatín pri ochoreniach obličiek: bezpečnosť a prínos</a></li>
  <li><a href="article.php?slug=kontrola-draslika-ckd-edukovat-nie-strasit">Kontrola draslíka pri CKD: edukovať, nie strašiť</a></li>
</ul>

<hr>

<h2>Odborné zdroje</h2>

<p id="odborny-zdroj-1"><small><em><strong>1. Východiskový materiál:</strong> Medscape. Gutmaxxing: Online Trend, Real-World GI Implications. 2026. Naratívny klinický komentár; autorstvo nie je v dostupnej časti materiálu jednoznačne uvedené, preto sa v tomto článku neuvádza. Odborné prahy a nefrologické súvislosti boli doplnené a overené podľa zdrojov nižšie.</em></small></p>

<p id="odborny-zdroj-2"><small><em><strong>2. Odporúčanie pre príjem bielkovín pri CKD:</strong> Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <em>Kidney International</em>. 2024;105(4 Suppl):S117–S314. doi: <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">10.1016/j.kint.2023.10.018</a>. Zdroj odporúčania 0,8 g/kg/deň pri CKD G3–G5 a praktického bodu o hranici 1,3 g/kg/deň pri riziku progresie.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Číselné prahy pre príjem bielkovín pri CKD boli overené podľa odporúčania KDIGO 2024; rozpätia uvádzané pre bežnú populáciu pochádzajú z východiskového materiálu a platia pre osoby bez ochorenia obličiek. Údaje o prevalencii tohto správania medzi pacientmi s CKD ani o jeho vplyve na progresiu ochorenia obličiek nie sú k dispozícii a článok ich neuvádza. Klasifikácia varovných znakov porúch príjmu potravy je uvedená ako orientačná; diagnostiku vykonáva psychiater alebo klinický psychológ.</em></small></p>

<p><small><em>Text má odborný informačný charakter a nenahrádza individuálne klinické rozhodovanie ani nutričné poradenstvo prispôsobené konkrétnemu pacientovi a štádiu ochorenia obličiek.</em></small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_gutmaxxing_rigidny_dietny_protokol',
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
    echo "Migrácia článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
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
