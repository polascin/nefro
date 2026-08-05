<?php

/**
 * add_occam-hickam-diagnosticke-uvazovanie-nefrologia_article.php
 * Occam vs Hickam - ako nefrologovia prepinaju medzi diagnostickymi ramcami.
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
    'title'        => 'Occam alebo Hickam? Ako nefrológovia prepínajú medzi diagnostickými rámcami',
    'slug'         => 'occam-hickam-diagnosticke-uvazovanie-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kanadská kvalitatívna štúdia opisuje, ako nefrológovia volia medzi jednou zjednocujúcou diagnózou a súbehom viacerých. Najznepokojivejší nález: časový tlak a tlak na hospodárnosť systematicky tlačia k najjednoduchšej obhájiteľnej diagnóze bez ohľadu na zložitosť prípadu.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Dve protichodné diagnostické zásady sprevádzajú medicínu už desaťročia: hľadaj jedno vysvetlenie — alebo počítaj s tým, že pacient môže mať naraz viac chorôb. Kanadská kvalitatívna štúdia sa pýtala nefrológov, kedy medzi nimi prepínajú. Najzávažnejší nález sa netýka uvažovania jednotlivca, ale prostredia, v ktorom pracuje.</em></p>

<p>Occamova britva odporúča nehromadiť vysvetlenia nad rámec nevyhnutnosti — hľadať jednu diagnózu, ktorá vysvetlí čo najviac nálezov. Hickamov diktát, pripisovaný americkému internistovi Johnovi Hickamovi, stojí proti nej v často citovanej podobe: pacient môže mať toľko chorôb, koľko sa mu zachce.</p>

<p>V nefrológii nejde o akademický spor. Typický nefrologický pacient je starší, má niekoľko chronických ochorení, užíva desiatky liekov a jeho laboratórne nálezy sú výsledkom viacerých súčasne prebiehajúcich procesov. Otázka, či hľadať jedno vysvetlenie alebo počítať so súbehom, sa v tejto špecializácii kladie takmer denne — a doteraz nebolo dobre popísané, podľa čoho sa nefrológovia rozhodujú.</p>

<h2>Ako štúdia postupovala</h2>

<p>Výskumný tím z Western University v Ontáriu, vedený Allegrou Ferrarou a Amritom Kirpalanim, uskutočnil <strong>pološtruktúrované rozhovory s deviatimi nefrológmi</strong> z rôznych častí Kanady. Rozhovory analyzoval induktívnym naratívnym prístupom, teda tak, že témy vznikali z výpovedí a neboli vopred stanovené.</p>

<p>Skúmané boli tri prelínajúce sa oblasti: <strong>medicínske vzdelávanie, individuálna klinická skúsenosť a systémové obmedzenia</strong>. Práve tretia z nich priniesla najzaujímavejší výsledok.</p>

<h2>Tri navzájom prepojené témy</h2>

<h3>1. Diagnostické uvažovanie sa učí implicitne — a rezidenti ho paradoxne zlepšujú</h3>

<p>Podľa výpovedí sa klinické rozhodovanie osvojuje predovšetkým <strong>vystavením prípadom, nie explicitnou výučbou</strong>. Nikto lekárov systematicky neučí, kedy opustiť jedno vysvetlenie a začať uvažovať o súbehu. Zručnosť sa buduje pozorovaním a praxou, čo znamená, že sa buduje nerovnomerne a nekontrolovane.</p>

<p>Zaujímavejší je druhý polovica nálezu: <strong>lekári v príprave narúšajú diagnostické rutiny svojich školiteľov spôsobom, ktorý znižuje riziko predčasného uzavretia</strong> diagnostickej úvahy. Otázka „a prečo si myslíte, že je to práve toto?“ od menej skúseného kolegu núti skúseného lekára svoju hypotézu vysloviť a obhájiť — a práve to je moment, keď sa nekonzistentnosť odhalí.</p>

<p>Prítomnosť rezidenta teda nie je len záťažou pre prevádzku. Je to lacný a účinný mechanizmus kontroly, ktorý na pracoviskách bez výučby chýba.</p>

<h3>2. So skúsenosťou vzniká kontextovo prispôsobivá stratégia</h3>

<p>S pribúdajúcou praxou nefrológovia podľa štúdie neprijímajú jeden z rámcov natrvalo, ale medzi nimi vedome striedajú: <strong>pri rutinných prezentáciách uplatňujú úspornosť, pri medicínsky zložitých pacientoch sa posúvajú k multifaktoriálnemu uvažovaniu</strong>.</p>

<p>To zodpovedá klinickej realite. Pri izolovanom náleze u inak zdravého mladého človeka je jedna diagnóza pravdepodobná. Pri hospitalizovanom pacientovi s pokročilou chronickou chorobou obličiek je naopak očakávateľné, že sa uplatní viacero mechanizmov naraz.</p>

<h3>3. Systém tlačí k Occamovi bez ohľadu na zložitosť prípadu</h3>

<p>Najzávažnejšia téma sa netýka lekára, ale prostredia. Podľa štúdie vytvárajú obmedzenia verejne financovaného systému <strong>štrukturálne skreslenie v prospech Occamovej britvy</strong>. Konkrétne uvádzanými mechanizmami sú <strong>časový tlak a hospodárne nakladanie so zdrojmi</strong>, ktoré klinikov posúvajú k „najjednoduchšej obhájiteľnej diagnóze“ — a to formuláciou autorov <em>bez ohľadu na zložitosť prípadu</em>.</p>

<p>Tento nález treba čítať pozorne. Nehovorí, že hospodárnosť je nesprávna, ani že jednoduché vysvetlenia sú spravidla chybné. Hovorí niečo špecifickejšie a znepokojujúcejšie: že voľba diagnostického rámca prestáva závisieť od klinického obrazu a začína závisieť od prevádzkových podmienok. Úspornosť sa z nástroja mení na návyk.</p>

<p>Slovné spojenie „najjednoduchšia obhájiteľná diagnóza“ pritom prezrádza podstatu problému. Obhájiteľnosť nie je to isté ako správnosť — je to vlastnosť, ktorá sa vzťahuje ku kontrole a k dokumentácii, nie k pacientovi.</p>

<h2>Kde v nefrológii vyhráva Hickam</h2>

<p>Autori sa konkrétnymi klinickými situáciami nezaoberajú, oplatí sa však doplniť, kde je súbeh v nefrológii skôr pravidlom než výnimkou:</p>

<ul>
  <li><strong>Akútne poškodenie obličiek u hospitalizovaného pacienta.</strong> Typicky pôsobí súčasne prerenálna zložka, tubulárne poškodenie a nefrotoxický liek. Priradenie celého vzostupu kreatinínu jedinej príčine vedie k tomu, že sa ošetrí len jedna z nich.</li>
  <li><strong>Proteinúria u pacienta s diabetom.</strong> Diabetická choroba obličiek je najpravdepodobnejším vysvetlením — no práve preto sa nediabetické ochorenie obličiek prehliada. Rýchly nástup, aktívny močový sediment alebo neprítomnosť retinopatie sú signálmi, že vysvetlenia môžu byť dve.</li>
  <li><strong>Anémia pri chronickej chorobe obličiek.</strong> Nedostatočná tvorba erytropoetínu býva len jednou zložkou; súčasne sa uplatňuje deficit železa, zápal, krvné straty alebo deficit vitamínu B<sub>12</sub> a folátu.</li>
  <li><strong>Hyponatriémia.</strong> Pacient môže mať naraz diuretikom navodenú stratu, zníženú schopnosť riedenia moču a nadmerný príjem tekutín.</li>
  <li><strong>Monoklonálna gamapatia s renálnym nálezom.</strong> Prítomnosť paraproteínu nevylučuje nezávislé ochorenie obličiek — a naopak, ochorenie obličiek nie je vždy len sprievodným nálezom.</li>
</ul>

<p>Spoločným menovateľom je, že jedno vysvetlenie tu spravidla existuje a je pravdepodobné. Práve preto je predčasné uzavretie také lákavé.</p>

<h2>Čo autori navrhujú</h2>

<p>Záver štúdie je konštruktívny. Kanadská príprava podľa autorov produkuje diagnosticky spôsobilých lekárov aj bez systematickej didaktickej výučby — nedáva im však rámec na to, aby rozpoznali, <em>kedy</em> je čas zmeniť heuristiku. Navrhované opatrenia sú tri:</p>

<ol>
  <li><strong>Explicitná výučba prepínania heuristík</strong> namiesto spoliehania sa na to, že sa zručnosť naučí sama.</li>
  <li><strong>Štruktúrovaná reflexia zabudovaná do klinických stáží</strong> — teda pravidelný priestor na otázku, prečo sme v konkrétnom prípade zvolili jedno vysvetlenie alebo viac.</li>
  <li><strong>Prostredie, ktoré vyvažuje systémový tlak</strong> stotožňujúci efektívnosť s diagnostickou úspornosťou.</li>
</ol>

<h2>Praktický prenos do každodennej práce</h2>

<p>Aj bez zmeny systému sa dá z nálezov odvodiť niekoľko použiteľných návykov:</p>

<ul>
  <li><strong>Pomenovať si prah revízie vopred.</strong> Otázka „čo by som musel vidieť, aby som prestal veriť tomuto vysvetleniu?“ je účinnejšia než dodatočná kontrola, lebo si vynúti formuláciu očakávania.</li>
  <li><strong>Pri neúplnej zhode neuzatvárať.</strong> Ak jedna diagnóza vysvetľuje väčšinu nálezov, ale nie všetky, zvyšok nie je šum — je to najcennejšia informácia v prípade.</li>
  <li><strong>Rozlišovať pracovnú a definitívnu diagnózu aj v dokumentácii.</strong> Zápis, ktorý znie definitívne, sa neskôr číta ako uzavretý a odrádza od prehodnotenia.</li>
  <li><strong>Využiť prítomnosť menej skúseného kolegu.</strong> Podľa štúdie práve jeho otázky znižujú riziko predčasného uzavretia — má teda zmysel ich vyžadovať, nie tolerovať.</li>
  <li><strong>Vnímať časový tlak ako rizikový faktor diagnostickej chyby</strong>, nie ako neutrálnu okolnosť. Vedomie, že prostredie tlačí k jednoduchšiemu záveru, je prvým krokom k jeho vyváženiu.</li>
</ul>

<h2>Limity</h2>

<p>Metodologické obmedzenia sú výrazné a autori ich nezakrývajú:</p>

<ul>
  <li><strong>Deväť účastníkov</strong> je pri kvalitatívnom výskume prijateľný, ale malý počet. Cieľom nie je zovšeobecniteľnosť ani kvantifikácia, ale hĺbkový opis.</li>
  <li>Rozhovory zachytávajú <strong>to, ako lekári svoje uvažovanie opisujú</strong>, nie priamo pozorované rozhodovanie. Rozdiel medzi deklarovanou a skutočnou praxou býva podstatný.</li>
  <li>Ide o <strong>kanadský verejne financovaný systém</strong>. Smer systémového skreslenia môže byť inde iný — v prostredí s výkonovou úhradou by tlak mohol pôsobiť opačne, teda k nadmernému vyšetrovaniu.</li>
  <li>Výskumný tím pôsobí na <strong>pediatrickom pracovisku</strong>, čo mohlo ovplyvniť výber účastníkov aj interpretačný rámec.</li>
  <li>Štúdia <strong>nedokladá</strong>, že navrhované zmeny vzdelávania zlepšia klinické výsledky. Ide o hypotézu vyplývajúcu z výpovedí, nie o overený účinok.</li>
</ul>

<h2>Záver</h2>

<p>Štúdia neprináša návod, kedy použiť Occama a kedy Hickama — a ani si to nekladie za cieľ. Jej hodnota je v tom, že pomenúva niečo, čo sa v diskusiách o diagnostických chybách spravidla obchádza: <strong>voľba diagnostického rámca nie je len kognitívnym aktom lekára, ale je formovaná prostredím</strong>.</p>

<p>Ak časový tlak a tlak na hospodárnosť systematicky posúvajú k najjednoduchšiemu obhájiteľnému záveru, potom sa časť diagnostických chýb nedá vyriešiť lepším vzdelávaním jednotlivcov. Úspornosť je dobrý nástroj vtedy, keď je vedomou voľbou. Prestáva ním byť vo chvíli, keď sa stane predvolenou odpoveďou na nedostatok času.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=kvalitativny-vyskum-nefrologia-rozhodovanie-pacientov-ckd">Kvalitatívny výskum v nefrológii a rozhodovanie pacientov s CKD</a>.</li>
  <li><a href="article.php?slug=kolagenozy-v-praxi-diagnosticke-a-terapeuticke-vyzvy">Kolagenózy v praxi</a> — diagnostické a terapeutické výzvy pri multisystémovom ochorení.</li>
  <li><a href="article.php?slug=umela-inteligencia-nefrologia-co-vieme-limity">Umelá inteligencia v nefrológii</a> — čo vieme a kde sú limity pri podpore rozhodovania.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Allegra Ferrara, Lucy Mason, Peter Ruberto, Keegan D'Mello, Amrit Kirpalani.</strong> <em>When the rules break down: how nephrologists navigate diagnostic complexity in real-world practice.</em> Journal of Nephrology. 2026 Aug 3 (online ahead of print). doi: 10.1093/joneph/aajag147. <a href="https://pubmed.ncbi.nlm.nih.gov/42544765/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1093/joneph/aajag147" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Pat Croskerry.</strong> <em>From mindless to mindful practice — cognitive bias and clinical decision making.</em> New England Journal of Medicine. 2013;368(26):2445–2448. doi: 10.1056/NEJMp1303712. <a href="https://pubmed.ncbi.nlm.nih.gov/23802513/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Mark L. Graber, Nancy Franklin, Ruthanna Gordon.</strong> <em>Diagnostic error in internal medicine.</em> Archives of Internal Medicine. 2005;165(13):1493–1499. doi: 10.1001/archinte.165.13.1493. <a href="https://pubmed.ncbi.nlm.nih.gov/16009864/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Bibliografické údaje, kompletné autorstvo, afiliácie aj doslovné znenie abstraktu vrátane všetkých troch tém a záverečných odporúčaní boli overené v zázname PubMed a v Europe PMC. Plný text štúdie je za platobnou bariérou vydavateľa a nebol sprístupnený; opis tém preto vychádza z abstraktu a neobsahuje citácie výpovedí účastníkov. Nefrologické príklady súbehu diagnóz, praktické návyky a komentár k pojmu „najjednoduchšia obhájiteľná diagnóza“ sú <strong>vlastným odborným spracovaním</strong>, nie tvrdením autorov štúdie.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_occam-hickam-diagnosticke-uvazovanie-nefrologia_article',
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
