<?php
/**
 * Odborne a jazykovo revidovaný článok o krehkosti u dialyzovaných pacientov
 * mladších než 65 rokov. Spracovaná prierezová štúdia z Tbilisi (Cureus 2026);
 * pôvodní autori sú uvedení v source_authors.php.
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

$articles = [];

$articles[] = [
    'title'        => 'Krehkosť u dialyzovaných pacientov mladších než 65 rokov: čo prináša prierezová štúdia z Tbilisi',
    'slug'         => 'krehkost-negeriatricki-dialyzovani-pacienti-frail-skala',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'V súbore 50 hemodialyzovaných pacientov vo veku 18–64 rokov bolo krehkých 20 % a predkrehkých 44 %. Skríning krehkosti teda nepatrí len do geriatrie – jednotlivé asociácie zo štúdie však treba čítať veľmi opatrne.',
    'content'      => <<<'HTML'
<p>Krehkosť sa v nefrológii stále vníma ako téma starších pacientov. Prierezová štúdia publikovaná v auguste 2026 v časopise <em>Cureus</em> to spochybňuje: v jednocentrovom súbore hemodialyzovaných dospelých vo veku 18 až 64 rokov bola krehkosť alebo predkrehkosť prítomná u takmer dvoch tretín pacientov.</p>

<p>Posolstvo o skríningu je správne a zodpovedá doterajšej literatúre. Niektoré jednotlivé výsledky štúdie však vyplývajú z veľmi malej vzorky a jeden z nich je biologicky nepravdepodobný natoľko, že by sa nemal preberať bez komentára.</p>

<h2>Čo štúdia urobila</h2>

<p>Išlo o prierezové hodnotenie <strong>50 pacientov vo veku 18–64 rokov</strong> s chronickou chorobou obličiek štádia 5D na udržiavacej hemodialýze v jednom centre v Tbilisi. Priemerný vek bol 54,34 ± 8,26 roka a 33 účastníkov (66 %) boli muži.</p>

<p>Krehkosť sa hodnotila <strong>škálou FRAIL</strong> – päťpoložkovým dotazníkom, ktorý sa pýta na únavu, schopnosť vyjsť desať schodov, schopnosť prejsť niekoľko sto metrov, počet ochorení a úbytok hmotnosti. Skóre 0 znamená zdatnosť, 1–2 predkrehkosť a 3 a viac krehkosť. Súvislosti sa hodnotili Fisherovým exaktným testom a multinomickou logistickou regresiou.</p>

<h2>Výsledky</h2>

<div class="table-responsive" role="region" aria-label="Rozdelenie krehkosti v súbore 50 hemodialyzovaných pacientov vo veku 18–64 rokov" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kategória podľa škály FRAIL</th>
      <th scope="col">Počet</th>
      <th scope="col">Podiel</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Zdatní</th>
      <td>18</td>
      <td>36 %</td>
    </tr>
    <tr>
      <th scope="row">Predkrehkí</th>
      <td>22</td>
      <td>44 %</td>
    </tr>
    <tr>
      <th scope="row">Krehkí</th>
      <td>10</td>
      <td>20 %</td>
    </tr>
  </tbody>
</table>
</div>

<p>V multinomickej regresii autori uvádzajú tri nálezy: fajčiarsku anamnézu (počet balíčkorokov) v <em>inverznom</em> vzťahu ku krehkosti (p = 0,021 pre porovnanie krehkí verzus zdatní a p = 0,005 pre porovnanie predkrehkí verzus krehkí), fosfatémiu ako významnú premennú v porovnaní predkrehkí verzus krehkí (p = 0,04, s nevýznamným trendom p = 0,092 v porovnaní krehkí verzus zdatní) a dĺžku dialyzačnej liečby, opäť len v porovnaní predkrehkí verzus krehkí (p = 0,016). Vzťah indexu telesnej hmotnosti a krehkosti bol nelineárny, s najvyšším podielom krehkých v podskupine s obezitou 1. stupňa – šlo však o štyroch pacientov zo siedmich. Komorbidity nevykázali štatisticky významnú súvislosť.</p>

<h2>Ako to sedí s doterajšími poznatkami</h2>

<p>Metaanalýza prevalencie krehkosti u hemodialyzovaných pacientov uvádza súhrnný odhad <strong>34,3 % (95 % IS 24,5–44,1)</strong> pri rozpätí jednotlivých štúdií 6 až 82 %. To rozpätie je samo osebe najdôležitejším údajom: prevalencia závisí od použitého nástroja, od definície a od zloženia súboru minimálne tak silno ako od skutočného zdravotného stavu populácie.</p>

<p>Rovnaká metaanalýza uvádza súhrnnú prevalenciu 56,0 % u pacientov mladších než 55 rokov, 32,3 % vo veku 55–65 rokov a 20,3 % vo veku 65 rokov a viac. Tento zdanlivo obrátený vekový gradient nemožno čítať ako dôkaz, že mladší dialyzovaní sú krehkejší než starší – ide o združenie heterogénnych štúdií s rôznymi nástrojmi. Podporuje však presne to, čo tvrdia autori z Tbilisi: <strong>krehkosť pri dialýze nie je záležitosťou veku samotného.</strong></p>

<p>Klinický význam nálezu je dobre podložený. V kohorte 2 275 incidentných dialyzovaných pacientov bola krehkosť po adjustácii spojená s úmrtnosťou (HR 2,24; 95 % IS 1,60–3,15) a so zloženým ukazovateľom hospitalizácie alebo úmrtia (HR 1,90; 95 % IS 1,67–2,17). Skríning krehkosti pri dialýze teda nepotrebuje ospravedlnenie novou štúdiou – potrebuje zavedenie do praxe.</p>

<h2>Kde treba byť opatrný</h2>

<ol>
  <li><strong>Vzorka je príliš malá na regresný model.</strong> Krehkých pacientov bolo desať. Multinomická logistická regresia s viacerými prediktormi pri takomto počte prípadov dáva nestabilné odhady. Zverejnené sú navyše len hodnoty p bez veľkostí účinku a intervalov spoľahlivosti, takže silu vzťahov nemožno posúdiť.</li>
  <li><strong>Nález o fajčení je takmer isto artefakt.</strong> Tvrdenie, že vyšší počet balíčkorokov sprevádza nižšiu krehkosť, odporuje celej doterajšej literatúre. Prichádzajú do úvahy najmenej tri vysvetlenia: obrátená príčinnosť (pacienti, ktorí zoslabli, prestali fajčiť), výberové skreslenie prežitím (fajčiari, ktorí by boli najkrehkejší, sa dialyzačnej kohorty nedožili) a jednoduchá náhoda pri malom počte prípadov. <strong>Fajčenie nemožno na základe tohto výsledku vykladať ako ochranný faktor.</strong></li>
  <li><strong>Podskupina s obezitou 1. stupňa mala sedem pacientov.</strong> Údaj 57,14 % predstavuje štyroch ľudí. Dve desatinné miesta pri takomto počte vytvárajú zdanie presnosti, ktoré neexistuje.</li>
  <li><strong>Škála FRAIL je dotazníková.</strong> Zachytáva sebahodnotenie, nie výkon. Prevalencia 20 % preto nie je priamo porovnateľná s číslami zo štúdií používajúcich Friedov fyzický fenotyp s meraním sily stisku a rýchlosti chôdze.</li>
  <li><strong>Smer vzťahu s fosfatémiou nie je známy.</strong> Prierezový dizajn nerozlíši, či nižší fosfát odráža nedostatočný príjem bielkovín pri chradnutí, alebo či vyšší fosfát odráža zlé dodržiavanie liečby viažucimi látkami. Klinicky ide o dva protichodné závery.</li>
  <li><strong>Jedno centrum a viacnásobné testovanie.</strong> Bez korekcie na počet porovnaní je časť „významných“ nálezov očakávateľná náhodou.</li>
  <li><strong>Označenie „negeriatrickí“ je zavádzajúce.</strong> Priemerný vek 54 rokov opisuje populáciu stredného až vyššieho stredného veku, nie mladých dospelých. Tvrdenie o krehkosti nezávislej od veku by presvedčivejšie doložil súbor s väčším zastúpením pacientov pod 45 rokov.</li>
</ol>

<h2>Vecná kontrola tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Vecná kontrola tvrdení štúdie o krehkosti u negeriatrických dialyzovaných pacientov" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Verdikt</th>
      <th scope="col">Presná interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Krehkosť a predkrehkosť sú u dialyzovaných pod 65 rokov časté</th>
      <td>Potvrdené</td>
      <td>V súbore 64 % pacientov nebolo zdatných. Zodpovedá to publikovanej metaanalýze aj klinickej skúsenosti.</td>
    </tr>
    <tr>
      <th scope="row">Krehkosť pri dialýze nie je daná len vekom</th>
      <td>Potvrdené</td>
      <td>Podporené aj metaanalýzou a staršími kohortovými údajmi; nejde o nové zistenie tejto štúdie.</td>
    </tr>
    <tr>
      <th scope="row">Fajčenie súvisí s nižšou krehkosťou</th>
      <td>Nepravdepodobné</td>
      <td>Biologicky neodôvodnené. Najpravdepodobnejšie ide o obrátenú príčinnosť, výberové skreslenie prežitím alebo náhodu pri desiatich krehkých pacientoch.</td>
    </tr>
    <tr>
      <th scope="row">Fosfatémia je klinicky významný korelát krehkosti</th>
      <td>Neisté</td>
      <td>Významnosť sa objavila len v jednom z porovnaní a smer vzťahu nie je z prierezového dizajnu určiteľný.</td>
    </tr>
    <tr>
      <th scope="row">Dlhšie trvanie dialýzy súvisí s krehkosťou</th>
      <td>Neisté</td>
      <td>Významné len v jednom porovnaní, bez uvedenej veľkosti účinku; klinicky vierohodné, ale touto štúdiou nedoložené presvedčivo.</td>
    </tr>
    <tr>
      <th scope="row">Obezita 1. stupňa je spojená s najvyššou krehkosťou</th>
      <td>Nedoložené</td>
      <td>Podskupina siedmich pacientov. Bez intervalu spoľahlivosti nejde o interpretovateľný údaj.</td>
    </tr>
    <tr>
      <th scope="row">Zistenia odôvodňujú rutinný skríning krehkosti</th>
      <td>Potvrdené s výhradou</td>
      <td>Skríning je odôvodnený, ale skoršími prognostickými údajmi, nie touto prierezovou analýzou.</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Čo z toho vyplýva pre prax</h2>

<p>Prierezová štúdia nezmení odporúčaný postup, môže však odstrániť dve zaužívané prekážky: predstavu, že krehkosť sa hodnotí až po sedemdesiatke, a predstavu, že jej hodnotenie je časovo náročné.</p>

<ol>
  <li><strong>Skrínovať bez vekovej hranice.</strong> Škála FRAIL zaberie dve minúty a nevyžaduje prístroje. Ak je k dispozícii dynamometer a priestor na meranie rýchlosti chôdze, výpovednejší je Friedov fenotyp.</li>
  <li><strong>Skrínovať opakovane.</strong> Pri vstupe do dialyzačného programu, potom aspoň raz ročne a vždy po hospitalizácii, páde, výraznom úbytku hmotnosti alebo funkčnom zhoršení.</li>
  <li><strong>Pozitívny skríning musí niečo spustiť.</strong> Nutričné zhodnotenie so zameraním na proteínovo-energetické chradnutie, posúdenie svalovej sily, cielenú pohybovú intervenciu vrátane cvičenia počas dialýzy, kontrolu anémie a metabolickej acidózy, revíziu liekov s dôrazom na tie, ktoré zvyšujú riziko pádov, a zhodnotenie nálady a spánku.</li>
  <li><strong>Prepojiť nález s rozhodovaním o trajektórii liečby.</strong> Krehkosť ovplyvňuje posudzovanie vhodnosti na transplantáciu, voľbu cievneho prístupu, rozvahu o domácej liečbe aj rozhovor o cieľoch starostlivosti.</li>
  <li><strong>Nezavádzať skríning bez následného postupu.</strong> Dotazník bez definovanej odpovede je administratívna záťaž, ktorá dôveryhodnosť celého nástroja skôr poškodí.</li>
</ol>

<h2>Záver</h2>

<p>Štúdia z Tbilisi je malá, jednocentrová a prierezová a jej regresné nálezy nemožno preberať ako klinické závery – zvlášť nie ten o fajčení. Jej hlavné posolstvo je napriek tomu správne a užitočné: <strong>medzi dialyzovanými pacientmi vo veku 18 až 64 rokov nebolo zdatných ani 40 %</strong>. Krehkosť je pri dialyzačnej liečbe klinickou premennou naprieč vekovými skupinami a jej vyhľadávanie má byť súčasťou bežnej nefrologickej starostlivosti, nie doplnkom vyhradeným pre geriatriu.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=sarkopenia-peritonealna-dialyza-modifikovany-kreatininovy-index">Sarkopénia pri peritoneálnej dialýze: prečo modifikovaný kreatinínový index nestačí</a></li>
  <li><a href="article.php?slug=myosteatoza-hemodialyza-ct-kvalita-svalstva">Myosteatóza pri hemodialýze: CT ukazovatele kvality svalstva sú sľubné, zatiaľ však nenahrádzajú funkčné vyšetrenie</a></li>
  <li><a href="article.php?slug=obezita-v-nefrologii-skrining-manazment-dialyza-transplantacia">Obezita v nefrológii: skríning, manažment a vplyv na dialýzu a transplantáciu</a></li>
</ul>

<hr>

<p><small><em><strong>Spracovaný zdroj:</strong> Ansar AF, Tsertsvadze N, Kashibadze B, Taundra TT, Jeevanandam V, Giuashvili M, Tchokhonelidze I. Frailty Syndrome in Non-geriatric Dialysis Patients in Georgia: Prevalence and Clinical Correlates in a Cross-Sectional Study. <em>Cureus</em>. 2026;18(8):e114700. doi: 10.7759/cureus.114700. <a href="https://doi.org/10.7759/cureus.114700" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://www.cureus.com/articles/517445-frailty-syndrome-in-non-geriatric-dialysis-patients-in-georgia-prevalence-and-clinical-correlates-in-a-cross-sectional-study" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></p>

<p><small><em><strong>Prevalencia krehkosti pri hemodialýze:</strong> Zhao Y, Liu Q, Ji J. The prevalence of frailty in patients on hemodialysis: a systematic review and meta-analysis. <em>International Urology and Nephrology</em>. 2020;52(1):115–120. doi: 10.1007/s11255-019-02310-2. <a href="https://pubmed.ncbi.nlm.nih.gov/31642001/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Prognostický význam krehkosti:</strong> Johansen KL, Chertow GM, Jin C, Kutner NG. Significance of frailty among dialysis patients. <em>Journal of the American Society of Nephrology</em>. 2007;18(11):2960–2967. doi: 10.1681/ASN.2007020221. <a href="https://pubmed.ncbi.nlm.nih.gov/17942958/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Prehľad krehkosti pri ochorení obličiek:</strong> Nair D, Liu CK, Raslan R, McAdams-DeMarco M, Hall RK. Frailty in Kidney Disease: A Comprehensive Review to Advance Its Clinical and Research Applications. <em>American Journal of Kidney Diseases</em>. 2025;85(1):89–103. doi: 10.1053/j.ajkd.2024.04.018. <a href="https://pubmed.ncbi.nlm.nih.gov/38906506/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje, úplný zoznam autorov a číselné výsledky spracovanej štúdie boli overené 23. augusta 2026 z metaúdajov vydavateľa a registra Crossref. Prierezový dizajn dovoľuje hodnotiť súvislosti v danom okamihu, nie príčinnosť.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_krehkost_negeriatricki_dialyzovani',
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
