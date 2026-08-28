<?php

/**
 * add_telesne-zlozenie-tukova-hmota-egfr-populacna-studia_article.php
 * Odborný článok: telesné zloženie a odhadovaná glomerulová filtrácia (kohorta SHIP).
 * Spracovaný zdroj: Günther MA, Ittermann T, Völzke H, et al. Clin Kidney J. 2026.
 * doi 10.1093/ckj/sfag261.
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
    'title'        => 'Telesné zloženie a odhadovaná glomerulová filtrácia: čo populačná analýza ukazuje a kde končí výpovedná hodnota eGFR',
    'slug'         => 'telesne-zlozenie-tukova-hmota-egfr-populacna-studia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'V nemeckej kohorte 4 211 dospelých sa vyššia tuková hmota spájala s nižšou eGFR, výraznejšie u žien a v staršom veku. Ide o prierezovú analýzu ovplyvnenú aj pôsobením telesného zloženia na samotné biomarkery.',
    'content'      => <<<'HTML'
<p>Vzťah medzi obezitou a funkciou obličiek sa zvyčajne opisuje priamočiaro: viac tuku, horšie obličky. Analýza z nemeckej populačnej kohorty <em>Study of Health in Pomerania</em> (SHIP) ukazuje, že obraz je zložitejší — smer asociácie sa mení podľa veku a jej sila podľa pohlavia. Pre nefrológa je pritom rovnako zaujímavá druhá otázka, ktorú práca otvára: nakoľko meriame funkciu obličiek a nakoľko meriame vplyv telesného zloženia na biomarkery, z ktorých ju odhadujeme.</p>

<h2>Čo analýza zahŕňala</h2>

<p>Vychádzala z údajov <strong>4 211 osôb</strong> zaradených do kohorty SHIP Trend-0. Telesné zloženie sa hodnotilo tromi spôsobmi:</p>

<ul>
  <li><strong>klasickou antropometriou</strong> — index telesnej hmotnosti (BMI) a pomer obvodu pása a bokov,</li>
  <li><strong>bioimpedančnou analýzou</strong>,</li>
  <li><strong>magnetickou rezonanciou</strong> s kvantifikáciou podkožného, viscerálneho a pečeňového tuku.</li>
</ul>

<p>Odhadovaná glomerulová filtrácia sa počítala rovnicami založenými na kreatiníne aj na cystatíne C. Analýza bola <strong>prierezová</strong>, s lineárnymi regresnými modelmi upravenými na zavádzajúce premenné.</p>

<h2>Výsledky</h2>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Hlavné zistenia o vzťahu telesného zloženia a odhadovanej glomerulovej filtrácie" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Zistenie</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Ukazovatele telesnej a tukovej hmoty</th>
        <td>Vyššie hodnoty sa vo všetkých použitých rovniciach spájali s <strong>nižšou eGFR</strong>.</td>
      </tr>
      <tr>
        <th scope="row">Relatívna beztuková hmota</th>
        <td>Vyšší podiel sa spájal s <strong>vyššou eGFR</strong>.</td>
      </tr>
      <tr>
        <th scope="row">Pohlavie</th>
        <td>Účinky boli <strong>výraznejšie u žien</strong> než u mužov.</td>
      </tr>
      <tr>
        <th scope="row">Vek</th>
        <td>V <strong>mladších</strong> vekových skupinách sa vyššia telesná a tuková hmota spájala s <strong>vyššou</strong> eGFR, v <strong>starších</strong> s <strong>nižšou</strong>. Pri relatívnej beztukovej hmote bola asociácia s vyššou eGFR výraznejšia v starších vekových skupinách.</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Autori uzatvárajú, že zvýšená telesná a tuková hmota — bez ohľadu na distribúciu tuku — a nižší podiel svalovej hmoty sa spájajú s nižšou eGFR, najmä u žien a u starších osôb.</p>

<h2>Vekový obrat: hyperfiltrácia ako najpravdepodobnejšie vysvetlenie</h2>

<p>Zmena smeru asociácie podľa veku nie je prekvapením, ale skôr potvrdením známeho javu. Obezita v mladšom veku býva spojená s <strong>glomerulovou hyperfiltráciou</strong>: zvýšený metabolický nárok, aktivácia systému renín-angiotenzín-aldosterón a zmeny tonusu aferentnej arterioly vedú k vyššej filtrácii na nefrón. Vyššia eGFR v tejto fáze teda nie je znakom lepšieho zdravia obličiek — je znakom záťaže, ktorá časom vedie k glomerulomegálii, k ohniskovej segmentovej glomeruloskleróze vo variante spojenej s obezitou a k poklesu funkcie.</p>

<p>V staršej vekovej skupine sa preto pozoruje opačný smer: kumulatívne poškodenie sa prejaví ako nižšia eGFR. Prierezová analýza zachytáva obe fázy naraz, ale u rôznych ľudí — nie priebeh u tých istých. To je zásadné obmedzenie a bráni tomu, aby sa výsledok čítal ako opis vývoja v čase.</p>

<h2>Kde je metodická hranica: eGFR nie je meraná GFR</h2>

<p>Toto je bod, ktorý si pri téme „telesné zloženie a obličky“ zaslúži osobitnú pozornosť. Analýza pracuje s <strong>odhadovanou</strong> filtráciou, a obidva jej biomarkery sú telesným zložením ovplyvnené nezávisle od skutočnej filtrácie:</p>

<ul>
  <li><strong>Kreatinín</strong> vzniká z kreatínu vo svale. Množstvo svalovej hmoty priamo ovplyvňuje jeho produkciu; pri rovnakej skutočnej GFR má osoba s väčšou svalovou hmotou vyšší kreatinín, a teda nižšiu vypočítanú eGFR.</li>
  <li><strong>Cystatín C</strong> je citlivý na tukovú hmotu, zápal nízkeho stupňa, funkciu štítnej žľazy a liečbu glukokortikoidmi. Tieto vplyvy sú označované ako <em>determinanty nezávislé od GFR</em> a pri obezite pôsobia smerom k vyššej koncentrácii — a teda k nižšej vypočítanej eGFR.</li>
</ul>

<p>Inými slovami: časť pozorovanej asociácie medzi tukovou hmotou a nižšou eGFR môže odrážať vplyv telesného zloženia na biomarkery, nie na filtráciu samotnú. Nie je to argument proti štúdii — je to argument za opatrné formulovanie záveru. Rozlíšiť tieto dve zložky by vyžadovalo <strong>meranú GFR</strong> exogénnym markerom (napr. iohexolom), čo v populačnej kohorte tejto veľkosti nie je uskutočniteľné.</p>

<h2>Ďalšie obmedzenia</h2>

<ul>
  <li><strong>Prierezový dizajn.</strong> Nemožno určiť, čo predchádzalo čomu, ani odhadnúť rýchlosť poklesu funkcie.</li>
  <li><strong>Selekcia účastníkov.</strong> Do populačných kohort sa častejšie zapájajú zdravší a pohyblivejší ľudia, čo môže oslabiť pozorované asociácie najmä v starších vekových skupinách.</li>
  <li><strong>Jedna populácia.</strong> Kohorta pochádza z jedného regiónu Nemecka; zloženie tela aj jeho vzťah k obličkovým ukazovateľom sa medzi populáciami líšia.</li>
  <li><strong>Rozsah dostupných údajov.</strong> Verejne prístupný abstrakt neuvádza počty účastníkov s jednotlivými zobrazovacími meraniami, konkrétne verzie použitých rovníc eGFR ani vekovú hranicu, pri ktorej sa smer asociácie obracia. Tieto údaje sa preto v článku neuvádzajú.</li>
</ul>

<h2>Čo si z toho odniesť do ambulancie</h2>

<ol>
  <li><strong>BMI je hrubý ukazovateľ.</strong> Pri hodnotení metabolického rizika hovorí distribúcia tuku viac než celková hmotnosť; to platí aj v nefrologickom kontexte.</li>
  <li><strong>Normálna alebo vysoká eGFR u mladého pacienta s obezitou nie je upokojujúci nález.</strong> Môže ísť o hyperfiltráciu. Doplnenie albuminúrie je v tejto situácii dôležitejšie než samotná eGFR.</li>
  <li><strong>Pri extrémoch telesného zloženia interpretujte eGFR opatrne.</strong> Pri výraznej sarkopénii aj pri veľmi vysokej svalovej hmote môže byť odhad z kreatinínu zavádzajúci; kombinovaná rovnica z kreatinínu a cystatínu C je vtedy spoľahlivejšia než ktorýkoľvek marker samostatne.</li>
  <li><strong>Zistenia nemenia liečebný postup.</strong> Ide o populačnú asociáciu, nie o nový rizikový nástroj ani o indikáciu na dodatočné vyšetrovanie zloženia tela.</li>
</ol>

<h2>Záver</h2>

<p>V populačnej kohorte sa vyššia telesná a tuková hmota spájala s nižšou odhadovanou glomerulovou filtráciou, výraznejšie u žien, pričom v mladších vekových skupinách bol smer asociácie opačný. Vekový obrat dobre zapadá do konceptu obezitou podmienenej hyperfiltrácie, ktorá časom prechádza do straty funkcie. Pri interpretácii však treba mať na pamäti, že prierezový dizajn neumožňuje kauzálne závery a že telesné zloženie ovplyvňuje aj samotné biomarkery, z ktorých sa filtrácia odhaduje.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=obezita-a-oblicky">Obezita a obličky</a></li>
  <li><a href="article.php?slug=renalna-funkcna-rezerva-normalny-egfr-poskodenie-obliciek">Renálna funkčná rezerva: prečo normálny eGFR nevylučuje významné poškodenie obličiek</a></li>
  <li><a href="article.php?slug=egfr-diabetes-ekfc-ckd-epi-stadia-ckd">Presnejší odhad eGFR u pacientov s diabetom: keď rovnica mení štádium CKD</a></li>
  <li><a href="article.php?slug=tukove-tkanivo-obezita-kardiorenalne-riziko-biologia">Tukové tkanivo, obezita a kardiorenálne riziko: čo hovorí biológia</a></li>
  <li><a href="article.php?slug=frailty-ckd-vyziva-pohyb-stisk-ruky">Krehkosť pri CKD: výživa, pohyb a stisk ruky</a></li>
</ul>

<hr>

<h2>Odborné zdroje</h2>

<p><small><em><strong>Spracovaný zdroj:</strong> Günther MA, Ittermann T, Völzke H, Stracke S, Endlich K, Bülow R, Nauck M, Wiese M, Aghdassi A, Markus MRP, von Rheinbaben S. Sex- and age-specific associations between body composition markers and estimated glomerular filtration rate — results of a population-based study. <em>Clinical Kidney Journal</em>. Publikované online 7. augusta 2026 (predbežný článok, bez ročníka a stránkovania). doi: <a href="https://doi.org/10.1093/ckj/sfag261" target="_blank" rel="noopener noreferrer">10.1093/ckj/sfag261</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje a úplný autorský zoznam boli overené 28. augusta 2026 cez Crossref; znenie abstraktu, veľkosť kohorty, spôsob merania telesného zloženia, typ analýzy aj smer zistených asociácií priamo zo stránky vydavateľa. Číselné hodnoty regresných koeficientov, počty účastníkov s jednotlivými zobrazovacími meraniami ani veková hranica obratu asociácie nie sú v dostupnom abstrakte uvedené, preto sa v článku neuvádzajú. Vysvetlenie cez hyperfiltráciu a výhrady k determinantom kreatinínu a cystatínu C nezávislým od GFR nie sú prevzaté od autorov; ide o štandardný nefrologický kontext doplnený pri spracovaní.</em></small></p>

<p><small><em>Text má odborný informačný charakter a nenahrádza individuálne klinické rozhodovanie. Hodnotenie funkcie obličiek u konkrétneho pacienta treba vždy posudzovať spolu s albuminúriou, klinickým stavom a použitou laboratórnou metódou.</em></small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_telesne_zlozenie_tukova_hmota_egfr',
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
