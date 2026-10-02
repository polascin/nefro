<?php
/**
 * add_kanabis-polyfarmacia-vedenie-vozidla-starsi-pacienti_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie odborného článku: zhoršenie schopnosti viesť vozidlo u starších
 * dospelých — akútne účinky Δ9-THC (metaanalýza McCartney 2021), simulátorová
 * štúdia u vodičov nad 65 rokov (Di Ciano 2024 JAMA Netw Open), kumulácia
 * s polyfarmáciou a praktický skríning v nefrologickej ambulancii.
 *
 * Autor projektu: MUDr. Ľubomír Polaščín. Odborné zhrnutie viacerých zdrojov
 * (McCartney 2021 Neurosci Biobehav Rev, Di Ciano 2024 JAMA Netw Open,
 * Hetland a Carr 2014 Ann Pharmacother) — nie preklad jedného zdrojového
 * článku, preto sa do source_authors.php nedopĺňajú pôvodní autori.
 *
 * Číselné údaje overené proti abstraktom v PubMede (PMID 33497784, 38236599,
 * 24473486).
 * Postup: git commit (SFTP deploy) → spustenie cez SSH.
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
    'title'        => 'Kanabis, polyfarmácia a vedenie vozidla u starších pacientov: čo hovoria dáta a na čo sa pýtať',
    'slug'         => 'kanabis-polyfarmacia-vedenie-vozidla-starsi-pacienti',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Metaanalýza 80 prác odhaduje, že väčšina schopností potrebných na vedenie vozidla sa po inhalácii 20 mg Δ9-THC upraví približne do 5 hodín. U vodičov nad 65 rokov bolo v simulátorovej štúdii zhoršenie merateľné 30 minút po fajčení, no po 3 hodinách už nie — pričom hladina THC v krvi so zhoršením nekorelovala vôbec. Prehľad pre ambulanciu, kde sa k tomu pridáva polyfarmácia.',
    'content'      => <<<'HTML'
<figure><a href="img/kanabis-polyfarmacia-vedenie-vozidla.webp" rel="noopener noreferrer" target="_blank"><img src="img/kanabis-polyfarmacia-vedenie-vozidla.webp" alt="Nočný pohľad spoza volantu: tmavá silueta rúk staršieho vodiča na volante a cez čelné sklo cesta rozpitá do zdvojených a posunutých pruhov svetla; nad prístrojovkou sa vznášajú stužky dymu a priesvitné kapsuly liekov, ktoré obraz za sebou skresľujú ako šošovky" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná scéna, nie záznam z jazdy ani zobrazenie konkrétneho pacienta. Podstata problému nie je jediná látka, ale to, čo sa v hlave vodiča sčítava.</figcaption></figure>

<p>Táto téma má k nefrológii nepriamy, ale celkom konkrétny vzťah. Nefrologická ambulancia je jedným z mála miest, kde sa <strong>systematicky prechádza celý zoznam liekov</strong> staršieho polymorbidného pacienta — a kde sa zároveň rieši krehkosť, riziko pádov a kognitívne zmeny. Práve to je kontext, v ktorom má otázka o kanabise a o jazde zmysel, a práve tam sa najčastejšie nepoloží.</p>

<p>Článok je o dvoch veciach: čo sa o zhoršení schopnosti viesť vozidlo dá povedať na základe dát, a ako to previesť do troch viet, ktoré sa dajú povedať pacientovi.</p>

<h2>Koľko to trvá: metaanalýza</h2>

<p>Najrozsiahlejšiu odpoveď na otázku <em>ako veľmi a ako dlho</em> dáva systematický prehľad s metaanalýzou publikovaný v <em>Neuroscience and Biobehavioral Reviews</em> (2021). Zahrnul <strong>80 publikácií a 1534 výstupov</strong> a hodnotil akútne účinky Δ<sup>9</sup>-tetrahydrokanabinolu (Δ<sup>9</sup>-THC) na výkon pri jazde a na kognitívne schopnosti s jazdou súvisiace.</p>

<p>Hlavné zistenia:</p>

<ul>
  <li>V metaanalýzach „vrcholových“ účinkov Δ<sup>9</sup>-THC bolo preukázané <strong>zhoršenie viacerých ukazovateľov</strong> — udržiavania stopy v jazdnom pruhu, sledovania a rozdelenej pozornosti (p &lt; 0,05).</li>
  <li><strong>Pravidelní užívatelia kanabisu boli zhoršení menej</strong> než ostatní, prevažne príležitostní užívatelia (p = 0,003). To nie je dobrá správa — znamená to, že údaje získané u pravidelných užívateľov riziko u bežného pacienta skôr <em>podhodnocujú</em>.</li>
  <li>Veľkosť zhoršenia závisela od dávky, od času od užitia a od toho, ktorá schopnosť sa testovala — a to osobitne pri perorálnom (243 odhadov účinku) aj inhalačnom (481 odhadov) podaní.</li>
</ul>

<p>Praktický výstup je nezvyčajne konkrétny. Model predpovedal, že väčšina s jazdou súvisiacich kognitívnych schopností sa <strong>upraví približne do 5 hodín</strong> (a takmer všetky približne do 7 hodín) po inhalácii <strong>20 mg Δ<sup>9</sup>-THC</strong>; po perorálnom užití môže zhoršenie trvať <strong>dlhšie</strong>. Autori z toho odvodzujú odporúčanie, ktoré sa dá povedať pacientovi doslova:</p>

<blockquote>
<p>Po inhalačnom užití kanabisu by mal človek počkať <strong>najmenej 5 hodín</strong>, kým vykoná činnosť citlivú na bezpečnosť.</p>
</blockquote>

<h2>A čo konkrétne starší vodiči</h2>

<p>Laboratórnych štúdií u ľudí nad 65 rokov bolo donedávna veľmi málo. Štúdia publikovaná v <em>JAMA Network Open</em> (2024) túto medzeru čiastočne zaplnila.</p>

<p><strong>Dizajn:</strong> 31 <em>pravidelných</em> užívateľov kanabisu (21 mužov, priemerný vek 68,7 roka; SD 3,5) jazdilo na simulátore pred fajčením, <strong>30 minút</strong> po ňom a <strong>180 minút</strong> po ňom — a v kontrolnej podmienke po oddychu, s vyváženým poradím. Účastníci fajčili <em>vlastný preferovaný legálny</em> kanabis; väčšina zvolila prípravok s prevahou THC s priemerným obsahom <strong>18,74 % THC</strong> (SD 6,12) a 1,46 % kanabidiolu (SD 3,37). Štúdia prebehla v Toronte od marca do novembra 2022.</p>

<div class="table-responsive" role="region" aria-label="Výsledky simulátorovej štúdie u vodičov nad 65 rokov" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Ukazovateľ</th><th scope="col">30 minút po fajčení</th><th scope="col">180 minút po fajčení</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Kolísanie v jazdnom pruhu (SDLP) — jednoduchá úloha</th><td><strong>zvýšené</strong> (veľkosť účinku 0,30)</td><td>bez rozdielu</td></tr>
    <tr><th scope="row">Kolísanie v jazdnom pruhu — rozptýlená pozornosť (dvojitá úloha)</th><td><strong>zvýšené</strong> (veľkosť účinku 0,27)</td><td>bez rozdielu</td></tr>
    <tr><th scope="row">Priemerná rýchlosť — jednoduchá úloha</th><td><strong>znížená</strong> (veľkosť účinku −0,58)</td><td>bez rozdielu</td></tr>
    <tr><th scope="row">Priemerná rýchlosť — dvojitá úloha</th><td><strong>znížená</strong> (veľkosť účinku −0,47)</td><td>bez rozdielu</td></tr>
    <tr><th scope="row">Hladina THC v krvi</th><td><strong>významne zvýšená</strong></td><td>bez významného zvýšenia</td></tr>
  </tbody>
</table>
<p><em>Di Ciano P a kol., JAMA Netw Open 2024;7(1):e2352233. Primárnym ukazovateľom bola smerodajná odchýlka bočnej polohy vozidla (SDLP, „kolísanie“). Porovnanie je voči kontrolnej podmienke.</em></p>
</div>

<p>Z tejto štúdie vyplývajú tri zistenia, ktoré sa oplatí poznať presne.</p>

<h3>1) Hladina THC v krvi nepredpovedá zhoršenie</h3>

<p>Toto je najdôležitejší — a najčastejšie prehliadaný — nález. <strong>Hladina THC v krvi nekorelovala s kolísaním v jazdnom pruhu ani s priemernou rýchlosťou</strong> v 30. minúte. Inými slovami: hodnota v krvi hovorí o tom, že človek <em>užil</em>, nie o tom, <em>ako veľmi je zhoršený</em>. Pre klinickú radu to znamená, že nemožno pracovať s predstavou „bezpečnej hladiny“ analogickou k alkoholu.</p>

<h3>2) Objektívne zhoršenie odznelo skôr než subjektívny pocit</h3>

<p>V 180. minúte už objektívne ukazovatele rozdiel nevykazovali — ale <strong>subjektívne hodnotenia účinku zostali zvýšené 5 hodín</strong> a účastníci uvádzali, že 3 hodiny po fajčení sú <em>menej ochotní</em> šoférovať. Je to zaujímavá disociácia a v poradenstve užitočná: pacient, ktorý „to na sebe ešte cíti“, má na svoj pocit dať — hoci v tomto konkrétnom experimente boli meradlá už v norme.</p>

<h3>3) Vzorka bola taká, že výsledok skôr podhodnocuje</h3>

<p>Účastníci boli <strong>pravidelní</strong> užívatelia — teda podľa metaanalýzy práve tá skupina, ktorá býva zhoršená <em>menej</em>. Zároveň išlo o malú vzorku (31 osôb), prevažne mužov, o jazdu na <em>simulátore</em>, nie na ceste, a o jednu krajinu s legálnym trhom a známym obsahom účinnej látky. Autori svoj záver formulujú primerane opatrne: starší vodiči by mali byť po fajčení kanabisu <strong>obozretní</strong>.</p>

<h2>Prečo je polyfarmácia zosilňovač</h2>

<p>Kanabis je v tejto rovnici len jedným sčítancom. Prehľadová práca o liekoch a zhoršení schopnosti viesť vozidlo (<em>Annals of Pharmacotherapy</em>, 2014) upozorňuje na skupiny, ktoré sa v medikácii starších pacientov objavujú rutinne — benzodiazepíny a Z-hypnotiká, opioidy, sedatívne antidepresíva, antipsychotiká, antihistaminiká prvej generácie, antiepileptiká a lieky s anticholínergným účinkom.</p>

<p>U staršieho pacienta sa k tomu pridáva:</p>

<ul>
  <li><strong>nižšia rezerva na kompenzáciu</strong> útlmu a spomalenej psychomotoriky,</li>
  <li>častejšie poruchy rovnováhy a zraku,</li>
  <li>a pri chronickej chorobe obličiek navyše <strong>zmenená eliminácia viacerých liečiv</strong>, takže „bežná“ dávka znamená vyššiu expozíciu. Typickým príkladom sú gabapentinoidy, ktoré sa vylučujú obličkami nezmenené — podrobnejšie v článku <a href="article.php?slug=gabapentin-bezpecnost-ckd-hemodialyza-temna-strana">o bezpečnosti gabapentínu pri CKD a hemodialýze</a>.</li>
</ul>

<p>Dôležitá je aj klinická realita, ktorú pacienti nehlásia sami: <strong>kanabis býva vnímaný ako „prírodný“, a teda ako niečo, čo do zoznamu liekov nepatrí.</strong> Pacient ho užíva na spánok, bolesť alebo úzkosť a nespojí si ho s medikáciou, ktorú práve preberáte. Rovnako nespojí riziko s kombináciou — a práve kombinácia je tu podstatná.</p>

<p>Širší kontext liekovej záťaže u pacientov s chorobou obličiek rozoberá článok <a href="article.php?slug=ckd-samostatny-faktor-polyfarmacie">o CKD ako samostatnom faktore polyfarmácie</a>. Kardiálnym účinkom inhalovaného kanabisu sa venuje <a href="article.php?slug=kanabis-inhalacia-kardialna-ektopia-randomizovana-crossover">samostatný článok o randomizovanej skríženej štúdii</a>.</p>

<h2>Čo robiť v ambulancii</h2>

<h3>Koho sa pýtať</h3>

<p>Nie každého. Zmysel to dáva u pacientov, ktorí sú <strong>starší</strong>, majú <strong>polyfarmáciu</strong>, užívajú <strong>psychofarmaká, opioidy alebo sedatíva</strong>, majú <strong>CKD</strong>, kognitívne ťažkosti alebo poruchy rovnováhy — a <strong>šoférujú</strong>.</p>

<h3>Ako sa pýtať</h3>

<p>Otázka funguje lepšie, keď nehľadá priznanie, ale informáciu:</p>

<ul>
  <li><strong>„Užívate kanabis — na spanie, na bolesť, na úzkosť alebo inak?“</strong> Uvedenie dôvodov otázku normalizuje a zvyšuje šancu na pravdivú odpoveď.</li>
  <li><strong>„Šoférujete v dňoch, keď ho užijete? A ako dlho po ňom?“</strong></li>
  <li>Prejdite zoznam liekov so zameraním na látky tlmiace CNS a anticholínergiká.</li>
</ul>

<h3>Čo povedať</h3>

<p>Tri vety, ktoré sú podložené dátami a dajú sa povedať bez moralizovania:</p>

<ol>
  <li><strong>„Po užití kanabisu nešoférujte.“</strong> Pri inhalačnom užití je rozumné počkať <strong>najmenej 5 hodín</strong>; po užití v jedle alebo nápoji môže zhoršenie trvať dlhšie.</li>
  <li><strong>„To, koľko máte látky v krvi, nehovorí o tom, ako ste zhoršený.“</strong> Pri kanabise neexistuje obdoba „bezpečnej hladiny“ ako pri alkohole.</li>
  <li><strong>„Riziko sa sčítava.“</strong> Pri súčasnom užívaní liekov tlmiacich CNS je zhoršenie väčšie, než by zodpovedalo samotnému kanabisu — a pri zníženej funkcii obličiek môžu byť tieto lieky účinnejšie a pôsobiť dlhšie.</li>
</ol>

<h3>Čo zapísať</h3>

<p>Do dokumentácie patrí, že otázka na kanabis a jazdu bola položená, aká bola odpoveď, že pacient dostal bezpečnostnú radu — a ak uviedol, že po užití šoféruje, aký plán sa dohodol. Je to krátky zápis, ktorý má hodnotu klinickú aj právnu.</p>

<h2>Čo tieto dáta nehovoria</h2>

<ul>
  <li><strong>Nehovoria, aké je riziko skutočnej dopravnej nehody u staršieho vodiča.</strong> Ide o simulátorové a laboratórne výsledky, nie o epidemiológiu kolízií v tejto vekovej skupine.</li>
  <li><strong>Nehovoria nič o kombinácii kanabisu s konkrétnymi liekmi.</strong> Interakčný efekt nebol v citovaných štúdiách meraný — tvrdenie o kumulácii vychádza z farmakologickej úvahy a z literatúry o liekoch a jazde, nie z priameho experimentu.</li>
  <li><strong>Nehovoria nič o pacientoch s CKD.</strong> Renálna časť tohto článku je extrapoláciou známych farmakokinetických princípov, nie výsledkom štúdie u tejto populácie. Uvádzame ju ako dôvod na opatrnosť, nie ako dokázanú asociáciu.</li>
  <li><strong>Hodnota „20 mg inhalovaného Δ<sup>9</sup>-THC“ je modelový vstup</strong>, nie dávka, ktorú pacient pozná. Reálne množstvo účinnej látky v tom, čo užíva, býva neznáme — čo je samostatný dôvod na konzervatívnu radu.</li>
</ul>

<h2>Záver</h2>

<p>Dáta o kanabise a jazde sú dnes dostatočné na to, aby sa z nich dala odvodiť jednoduchá a obhájiteľná rada: <strong>po inhalačnom užití počkať najmenej päť hodín, po perorálnom dlhšie, a nespoliehať sa na hladinu v krvi ani na vlastný pocit.</strong></p>

<p>Pre nefrologickú ambulanciu z toho nevyplýva nová agenda, ale jedna doplnená otázka pri revízii medikácie. Jej hodnota nie je v tom, že odhalí užívateľa — ale v tom, že u pacienta, ktorý už berie tri lieky tlmiace centrálny nervový systém a má zníženú funkciu obličiek, pomenuje riziko, ktoré inak zostane nepomenované.</p>

<hr>

<p><em><strong>Zdroje:</strong></em></p>

<ol>
  <li>McCartney D, Arkell TR, Irwin C, McGregor IS. <em>Determining the magnitude and duration of acute Δ<sup>9</sup>-tetrahydrocannabinol (Δ<sup>9</sup>-THC)-induced driving and cognitive impairment: A systematic and meta-analytic review.</em> Neurosci Biobehav Rev 2021;126:175–193. <a href="https://doi.org/10.1016/j.neubiorev.2021.01.003" target="_blank" rel="noopener noreferrer">doi:10.1016/j.neubiorev.2021.01.003</a> (PMID 33497784).</li>
  <li>Di Ciano P, Rajji TK, Hong L a kol. <em>Cannabis and Driving in Older Adults.</em> JAMA Netw Open 2024;7(1):e2352233. <a href="https://doi.org/10.1001/jamanetworkopen.2023.52233" target="_blank" rel="noopener noreferrer">doi:10.1001/jamanetworkopen.2023.52233</a> (PMID 38236599).</li>
  <li>Hetland A, Carr DB. <em>Medications and Impaired Driving.</em> Ann Pharmacother 2014;48(4):494–506. <a href="https://doi.org/10.1177/1060028014520882" target="_blank" rel="noopener noreferrer">doi:10.1177/1060028014520882</a> (PMID 24473486).</li>
</ol>

<p><em>Bibliografické údaje všetkých citovaných prác boli overené v databáze PubMed.</em></p>

<p><em><strong>Upozornenie:</strong> Článok je určený zdravotníckym pracovníkom, má informatívny charakter a nenahrádza platnú legislatívu upravujúcu spôsobilosť viesť motorové vozidlo ani individuálne posúdenie zdravotnej spôsobilosti.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_kanabis-polyfarmacia-vedenie-vozidla-starsi-pacienti_article',
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
