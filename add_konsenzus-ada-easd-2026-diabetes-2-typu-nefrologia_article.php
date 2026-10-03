<?php
/**
 * add_konsenzus-ada-easd-2026-diabetes-2-typu-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie odborného článku: konsenzus ADA a EASD o manažmente diabetu 2. typu
 * (2026), predstavený na 62. výročnom stretnutí EASD v Miláne (28. 9. – 2. 10.
 * 2026) a súčasne publikovaný v Diabetes Care — z nefrologickej perspektívy.
 *
 * Autor projektu: MUDr. Ľubomír Polaščín. Odborné zhrnutie publikovaného
 * konsenzuálneho dokumentu (Davies 2026, Diabetes Care) doplnené
 * o nefrologický kontext (FLOW, protokol RESET for REMISSION) — nie preklad
 * jedného zdrojového článku, preto sa do source_authors.php nedopĺňajú
 * pôvodní autori.
 *
 * Obsah konsenzu je citovaný výhradne podľa publikovaného abstraktu
 * (PMID 42825450, doi:10.2337/dci26-0141); nepublikované kongresové
 * prezentácie sa zámerne necitujú ako zdroj čísel.
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
    'title'        => 'Konsenzus ADA a EASD 2026: diabetes 2. typu prestáva byť ochorením glykémie',
    'slug'         => 'konsenzus-ada-easd-2026-diabetes-2-typu-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Na kongrese EASD v Miláne bol predstavený a súčasne publikovaný nový konsenzus ADA a EASD o manažmente diabetu 2. typu. Dokument rozširuje zameranie z liečby hyperglykémie na celostný manažment ochorenia a jeho dlhodobých komplikácií a odporúča skoršie — potenciálne už od diagnózy — nasadenie inhibítorov SGLT2 a liečby založenej na GLP-1 pre orgánovú ochranu. Čo z toho vyplýva pre nefrologickú prax.',
    'content'      => <<<'HTML'
<figure><a href="img/konsenzus-ada-easd-2026-diabetes.webp" rel="noopener noreferrer" target="_blank"><img src="img/konsenzus-ada-easd-2026-diabetes.webp" alt="V tmavom priestore leží na podstavci jediný svietiaci kryštálik cukru pod úzkym bodovým svetlom; lúč sa rozširuje do širokého pásu, ktorý z tmy odhaľuje sústavu priesvitných svietiacich orgánov — srdce, dve obličky a pečeň — pospájaných jemnými svetelnými vláknami" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná scéna, nie klinický záznam. Podstata zmeny v jednom obraze: svetlo, ktoré roky svietilo na jediný ukazovateľ, sa rozširuje na orgány, ktoré o prognóze pacienta rozhodujú.</figcaption></figure>

<p>Na <strong>62. výročnom stretnutí Európskej asociácie pre štúdium diabetu (EASD)</strong>, ktoré sa konalo v Miláne od 28. septembra do 2. októbra 2026, bol predstavený a <strong>súčasne publikovaný</strong> nový spoločný konsenzuálny dokument <strong>Americkej diabetologickej asociácie (ADA) a EASD</strong> o manažmente diabetu 2. typu u netehotných dospelých.</p>

<p>Ide o aktualizáciu série, ktorá vychádza od roku 2006 a naposledy bola aktualizovaná v roku 2022. Pre nefrológa je podstatné, že v panele sedeli aj <strong>nefrológovia</strong> — Sylvia E. Rosas a Peter Rossing — a že obličky sa v dokumente neobjavujú ako jedna z komplikácií na konci zoznamu, ale ako jeden z dôvodov, prečo sa celá logika liečby mení.</p>

<h2>Čo sa zmenilo: od glykémie k orgánom</h2>

<p>Najvýznamnejšia zmena je formulovaná priamo v publikovanom dokumente: aktualizácia <strong>rozšírila zameranie z manažmentu hyperglykémie na celostný manažment diabetu 2. typu a rizika pridružených viacnásobných dlhodobých ochorení</strong>.</p>

<p>Prakticky to znamená tri posuny:</p>

<div class="table-responsive" role="region" aria-label="Hlavné posuny v konsenze ADA a EASD 2026" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Oblasť</th><th scope="col">Čo konsenzus 2026 hovorí</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Základ starostlivosti</th><td>Podpora zdravého životného štýlu — zdravé stravovanie, <strong>24-hodinové pohybové správanie vrátane spánku</strong>, vyhýbanie sa tabaku a návykovým látkam — spolu s <strong>psychologickou podporou</strong> a intervenciami zameranými na manažment hmotnosti</td></tr>
    <tr><th scope="row">Farmakoterapia</th><td><strong>Skoršie použitie, potenciálne už od diagnózy</strong>, inhibítorov SGLT2 a/alebo liečby založenej na GLP-1 s cieľom <strong>orgánovej ochrany</strong> a zlepšenia dlhodobých výsledkov</td></tr>
    <tr><th scope="row">Kombinačná liečba</th><td><strong>Skoršie kombinované použitie</strong> inhibítora SGLT2 a liečby založenej na GLP-1 treba zvážiť u ľudí so súčasne prítomným <strong>kardiovaskulárnym ochorením, chronickou chorobou obličiek a srdcovým zlyhávaním</strong></td></tr>
  </tbody>
</table>
<p><em>Podľa Davies MJ a kol., Diabetes Care 2026, doi:10.2337/dci26-0141. Formulácie sú prevzaté z publikovaného abstraktu dokumentu.</em></p>
</div>

<p>Dva detaily v tejto tabuľke sa oplatí prečítať dvakrát.</p>

<p>Prvým je spojenie <strong>„potenciálne už od diagnózy“</strong>. Doterajšia logika — metformín, potom pridať niečo ďalšie — sa tým neruší explicitne, ale prestáva byť samozrejmým východiskom. Dôvodom nie je lepšia glykemická účinnosť, ale <strong>orgánová ochrana</strong>: liečivá sa nasadzujú kvôli tomu, čo robia so srdcom a obličkami, nie kvôli tomu, o koľko znížia HbA1c.</p>

<p>Druhým je <strong>skoršia kombinácia</strong> inhibítora SGLT2 a liečby založenej na GLP-1. Pre nefrológa je to najpriamejšia veta celého dokumentu — práve naša populácia je tá, v ktorej sa „súčasne prítomné kardiovaskulárne ochorenie, CKD a srdcové zlyhávanie“ vyskytuje najčastejšie.</p>

<h2>Prečo práve tieto dve skupiny</h2>

<p>Konsenzus vychádza zo systematického prehľadu publikácií od roku 2022 — a práve v tomto období pribudli dáta, ktoré renálnu indikáciu obidvoch skupín podstatne posilnili.</p>

<p>Pre nefrológiu je najvýznamnejšia štúdia <strong>FLOW</strong> (<em>New England Journal of Medicine</em>, 2024), ktorá zaradila 3533 pacientov s diabetom 2. typu a chronickou chorobou obličiek a randomizovala ich na subkutánny semaglutid 1,0 mg týždenne alebo placebo. Pri mediáne sledovania 3,4 roka bol primárny zložený renálny a kardiovaskulárny ukazovateľ o <strong>24 % nižší</strong> (pomer rizík 0,76; 95 % IS 0,66 – 0,88), kardiovaskulárne úmrtie o 29 % nižšie (0,71; 0,56 – 0,89) a úmrtie z akejkoľvek príčiny o 20 % nižšie (0,80; 0,67 – 0,95). Štúdia bola <strong>predčasne ukončená</strong> na odporúčanie po prednastavenej priebežnej analýze.</p>

<p>Dôkazový základ pre inhibítory SGLT2 pri CKD bol pevný už predtým. Novinkou roku 2026 teda nie je samotný dôkaz, ale <strong>posun v načasovaní a v tom, že obe skupiny sa čoraz častejšie majú kombinovať, nie zoraďovať za sebou</strong>. Praktické dôsledky kombinačnej liečby rozoberá samostatný článok <a href="article.php?slug=kombinacna-liecba-ckd-styri-piliere-hranice-dokazov">o štyroch pilieroch a hraniciach dôkazov</a>.</p>

<h2>Nefrologické poznámky k implementácii</h2>

<p>Konsenzus je dokumentom o tom, <em>čo</em> robiť. Nefrologická prax sa láme na tom, <em>ako</em> to robiť bezpečne u pacienta s poklesom eGFR.</p>

<h3>1) Metformín: individualizácia podľa renálnej funkcie zostáva</h3>

<p>Posun k skoršiemu nasadeniu inhibítorov SGLT2 a GLP-1 neznamená, že metformín pri CKD prestáva podliehať renálnym pravidlám. Rozhodnutie sa naďalej riadi odhadovanou glomerulovou filtráciou, znášanlivosťou a rizikom laktátovej acidózy podľa platných odporúčaní a SPC. Z praktického hľadiska sa však mení poradie otázok: namiesto „kedy pridať druhý liek k metformínu“ sa pýtame „čo tento pacient potrebuje pre ochranu obličiek a srdca — a je metformín pri jeho renálnej funkcii vhodným doplnkom“.</p>

<h3>2) Očakávaný úvodný pokles eGFR</h3>

<p>Pri nasadení inhibítora SGLT2 (a v menšej miere pri ďalších nefroprotektívnych liečivách) sa typicky objaví <strong>počiatočný pokles eGFR</strong>, ktorý je hemodynamický, reverzibilný a je <em>priaznivým</em> prognostickým znakom. Jeho nerozpoznanie vedie k zbytočnému vysadeniu práve toho lieku, ktorý pacienta chráni. Pri skoršom nasadení u pacientov s lepšou východiskovou funkciou obličiek bude táto situácia v ambulanciách častejšia — a tým aj riziko nesprávnej reakcie.</p>

<h3>3) Objemová deplécia a pravidlo chorého dňa</h3>

<p>Kombinácia inhibítora SGLT2, agonistu GLP-1, diuretika a blokády systému renín-angiotenzín-aldosterón je účinná — a pri interkurentnom ochorení riziková. Gastrointestinálne nežiaduce účinky liečby založenej na GLP-1 môžu viesť k zníženému príjmu tekutín a k objemovej deplécii, čo je najčastejšia cesta k akútnemu poškodeniu obličiek u týchto pacientov. <strong>Každý pacient na kombinovanej liečbe potrebuje dohodnuté pravidlo chorého dňa</strong> — čo vysadiť pri vracaní, hnačke alebo horúčke a kedy sa ozvať. Podrobnejšie k tomu článok <a href="article.php?slug=prehadzovanie-glp1-agonistov-prakticky-postup-ckd">o prechode medzi agonistami GLP-1</a>.</p>

<h3>4) Skríning komplikácií sa rozširuje aj na pečeň</h3>

<p>Celostný rámec konsenzu zahŕňa riziko <strong>viacnásobných dlhodobých ochorení</strong>, nielen klasickú štvoricu oko – oblička – srdce – nerv. Steatotické ochorenie pečene spojené s metabolickou dysfunkciou zdieľa s CKD metabolické aj kardiovaskulárne mechanizmy a v nefrologickej populácii je bežné; téme sa venujú samostatné články o <a href="article.php?slug=masld-diagnostika-fibroza-nefrologicka-prax">diagnostike fibrózy pri MASLD</a> a o <a href="article.php?slug=steatoticke-ochorenie-pecene-riziko-ckd">steatotickom ochorení pečene ako rizikovom faktore CKD</a>.</p>

<h3>5) Hypoglykémia a technológia</h3>

<p>Pri CKD je riziko hypoglykémie vyššie — mení sa farmakokinetika viacerých liečiv aj renálna glukoneogenéza. Pokiaľ pacient užíva inzulín alebo deriváty sulfonylmočoviny, kontinuálne monitorovanie glukózy je predovšetkým <strong>bezpečnostný</strong>, nie optimalizačný nástroj. Prínos tu nie je renálny priamo, ale cez zníženie počtu hypoglykémií u krehkých pacientov. Dôkazy pri diabete 2. typu bez inzulínu rozoberá <a href="article.php?slug=kontinualne-monitorovanie-glukozy-diabetes-2-typu-bez-inzulinu">samostatný článok</a>.</p>

<h2>Veta, ktorá je v dokumente najdôležitejšia</h2>

<p>Konsenzus sa neuzatvára novým liečivom ani novým cieľom. Uzatvára sa konštatovaním, že schopnosť zásadne zmeniť výsledky pacientov s diabetom 2. typu je <strong>na dosah — prostredníctvom dôsledného, spravodlivého a systematického zavádzania stratégií a liečiv, ktoré sú už dnes dostupné</strong>.</p>

<p>To je z nefrologického pohľadu najpoctivejšia veta celého dokumentu. Hlavnou prekážkou nefroprotekcie pri diabete dnes nie je chýbajúci dôkaz ani chýbajúce liečivo. Je ňou to, že <strong>pacienti, ktorí by z liečby profitovali, ju nedostávajú</strong> — pre oneskorenú diagnózu CKD, nevykonaný skríning albuminúrie, obavu z úvodného poklesu eGFR, úhradové prekážky alebo jednoducho preto, že nikto neprevzal zodpovednosť za to, kto liek nasadí.</p>

<h2>Čo tento článok zámerne neobsahuje</h2>

<p>Na kongrese EASD 2026 odzneli aj výsledky štúdií, ktoré zatiaľ <strong>nie sú recenzovane publikované</strong> — napríklad randomizovanej štúdie <strong>RESET for REMISSION</strong>, ktorá u mladých dospelých (18 až 45 rokov) do 6 rokov od diagnózy diabetu 2. typu skúma remisiu po kombinácii nízkoenergetickej diéty (800 až 900 kcal denne počas 12 týždňov) so supervidovaným aeróbnym a silovým tréningom trikrát týždenne, s následnou 12-týždňovou udržiavacou fázou; primárnym ukazovateľom je remisia definovaná ako HbA1c pod 6,5 % v 24. týždni bez liečiv znižujúcich glykémiu počas udržiavacej fázy.</p>

<p>Protokol tejto štúdie je publikovaný a overiteľný; <strong>jej výsledky tu neuvádzame</strong>, kým nebudú dostupné v recenzovanej podobe. To isté platí pre prezentácie nových inkretínových liečiv. Kongresová prezentácia je legitímny spôsob komunikácie vedy, ale nie je dostatočným podkladom na čísla v odbornom texte ani na zmenu praxe.</p>

<p>Z nefrologického hľadiska stojí pri remisných režimoch za zmienku jedna praktická vec, ktorá platí bez ohľadu na výsledok štúdie: <strong>výrazná dietetická intervencia u pacienta s rizikom CKD mení hemodynamiku</strong>. Pri prudkom úbytku hmotnosti a zmenenom príjme tekutín treba počítať s hypotenziou, so zhoršenou toleranciou blokády RAAS a s potrebou skorého prehodnotenia dávok — teda s plánom monitorovania kreatinínu, ionogramu a krvného tlaku, nie s jednorazovou kontrolou o pol roka.</p>

<h2>Záver</h2>

<p>Konsenzus ADA a EASD 2026 nie je revolúciou v tom zmysle, že by priniesol nové liečivo. Je posunom v <strong>definícii problému</strong>: diabetes 2. typu sa v ňom prestáva správať ako ochorenie glykémie a začína sa správať ako ochorenie viacerých orgánov, v ktorom je oblička jedným z hlavných cieľov ochrany, nie neskorou komplikáciou.</p>

<p>Pre nefrológa z toho vyplýva menej dramatický, ale praktickejší záver: liečivá, ktoré roky používame u pacientov s pokročilou CKD, majú podľa tohto dokumentu patriť k pacientom <em>skôr</em> — a často <em>v kombinácii</em>. Úlohou nefrológie nie je čakať, kým ich pacient dostane od niekoho iného.</p>

<hr>

<p><em><strong>Zdroje:</strong></em></p>

<ol>
  <li>Davies MJ, Aroda VR, Bajaj M, ElSayed NA, Giorgino F, Green J, Kalyani RR, Maruthur NM, Mathieu C, Rosas SE, Rossing P, Slater T, Tankova T, Topsever P, Tsapas A, Buse JB. <em>Management of Type 2 Diabetes, 2026. A Consensus Report by the American Diabetes Association (ADA) and the European Association for the Study of Diabetes (EASD).</em> Diabetes Care 2026. <a href="https://doi.org/10.2337/dci26-0141" target="_blank" rel="noopener noreferrer">doi:10.2337/dci26-0141</a> (PMID 42825450).</li>
  <li>Perkovic V, Tuttle KR, Rossing P a kol. <em>Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes</em> (štúdia FLOW). N Engl J Med 2024;391(2):109–121. <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa2403347</a> (PMID 38785209).</li>
  <li>Dasgupta K, Boulé N, Henson J a kol. <em>Remission of type 2 diabetes and improved diastolic function by combining structured exercise with meal replacement and food reintroduction among young adults: the RESET for REMISSION randomised controlled trial protocol.</em> BMJ Open 2022;12(9):e063888. <a href="https://doi.org/10.1136/bmjopen-2022-063888" target="_blank" rel="noopener noreferrer">doi:10.1136/bmjopen-2022-063888</a> (PMID 36130753). <em>Citovaný je protokol, nie výsledky.</em></li>
  <li>62. výročné stretnutie EASD, Miláno, 28. 9. – 2. 10. 2026. <a href="https://www.easd.org/annual-meeting/easd-2026/" target="_blank" rel="noopener noreferrer">easd.org</a>.</li>
</ol>

<p><em>Bibliografické údaje citovaných prác boli overené v databáze PubMed. Obsah konsenzuálneho dokumentu je citovaný podľa jeho publikovaného abstraktu.</em></p>

<p><em><strong>Upozornenie:</strong> Článok je určený zdravotníckym pracovníkom a nenahrádza úplné znenie konsenzuálneho dokumentu, platné súhrny charakteristických vlastností liečiv ani individuálne klinické rozhodnutie.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_konsenzus-ada-easd-2026-diabetes-2-typu-nefrologia_article',
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
