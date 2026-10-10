<?php

/**
 * Odborný článok o longitudinálnej interpretácii kalciémie pri hemodialýze.
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
    'title'        => 'Dynamika kalciémie pri hemodialýze: prečo nestačí jediný výsledok',
    'slug'         => 'dynamika-kalciemie-hemodialyza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kalciémiu pri hemodialýze treba hodnotiť v čase a v kontexte albumínu, pH, fosfatémie, PTH, dialyzačného predpisu a liečby. Nová analýza DOPPS ukazuje prognostický význam jej trendu a nestability.',
    'content'      => <<<'HTML'
<figure><a href="img/dynamika-kalciemie-hemodialyza.webp" target="_blank" rel="noopener noreferrer"><img src="img/dynamika-kalciemie-hemodialyza.webp" alt="Poloschematický dialyzátor, obličky a kosť s časovou krivkou opakovaných meraní kalciémie" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračné znázornenie rozdielu medzi izolovaným výsledkom a časovým priebehom kalciémie pri hemodialýze. Svetelné prvky sú symbolické; nejde o zobrazenie meraných dát ani o anatomický model transportu vápnika.</figcaption></figure>

<p>Koncentrácia vápnika v sére patrí medzi pravidelne sledované parametre u pacientov liečených hemodialýzou. Jej interpretácia však nie je jednoduchým porovnaním jediného výsledku s referenčným intervalom. Kalciémia odráža minerálový a kostný metabolizmus, výživový a zápalový stav, acidobázickú rovnováhu, dialyzačný predpis aj farmakoterapiu.</p>

<p>Význam má preto aktuálna hodnota aj jej vývoj. Opakovaná hyperkalciémia, pretrvávajúca hypokalciémia, rastúci trend a výrazné kolísanie predstavujú rozdielne klinické situácie. <strong>Trend môže upozorniť na riziko, sám však neurčuje príčinu ani automatickú zmenu liečby.</strong> Interpretácia vyžaduje súčasné hodnotenie fosfatémie, parathormónu (PTH), albumínu, klinického stavu a zmien terapie. [1,2]</p>

<h2>Čo vlastne meriame</h2>

<p>Celkový vápnik zahŕňa ionizovanú frakciu, frakciu viazanú najmä na albumín a vápnik v komplexoch s aniónmi. Bezprostredne biologicky účinný je ionizovaný vápnik. Pri poklese albumínu môže klesnúť celková kalciémia bez porovnateľného poklesu ionizovanej frakcie. Zmena pH zasa ovplyvňuje väzbu na albumín: alkalémia ju zvyšuje a môže znižovať ionizovaný vápnik bez výraznej zmeny celkového vápnika.</p>

<p>Výpočtová korekcia celkového vápnika na albumín má pri hemodialýze významné obmedzenia. V štúdii stabilných hemodialyzovaných pacientov bežne používané korekčné vzorce nezlepšili klasifikáciu oproti nekorigovanému celkovému vápniku a Payneov vzorec sa s ionizovaným vápnikom zhodoval dokonca horšie. Pri klinicko-laboratórnom nesúlade je preto vhodnejšie zvážiť priame meranie ionizovaného vápnika. [3]</p>

<p>Aj ionizovaný vápnik je citlivý na preanalytické podmienky. Kontakt vzorky so vzduchom, oneskorené spracovanie a zmena pH môžu výsledok skresliť; rozhodnutie sa preto nemá opierať o technicky pochybný odber.</p>

<h2>Prečo je dôležitý časový priebeh</h2>

<p>Jednorazový výsledok môže zachytiť prechodnú zmenu objemového stavu, interkurentné ochorenie, nedávnu úpravu liečby alebo odlišné načasovanie odberu. Séria porovnateľne odobratých vzoriek umožňuje odlíšiť stabilnú hodnotu, pretrvávajúcu odchýlku, systematický vzostup či pokles a nepravidelné výkyvy.</p>

<p>Priemer, sklon trendu, smerodajná odchýlka, variačný koeficient a čas mimo zvoleného rozmedzia opisujú rozdielne vlastnosti priebehu. Pacient s dlhodobo mierne zvýšenou kalciémiou môže mať rovnaký priemer ako pacient, u ktorého sa striedajú nízke a vysoké hodnoty. Preto sa výsledky štúdií o „variabilite“ nedajú porovnávať bez znalosti použitej definície.</p>

<h2>Čo priniesla nová analýza DOPPS</h2>

<p>Iseri a spolupracovníci analyzovali údaje medzinárodnej prospektívnej kohorty DOPPS z rokov 2009–2022. V štvrťročných landmarkových bodoch zhrnuli hodnoty celkového vápnika z predchádzajúcich 180 dní ako poslednú hodnotu, priemer, lineárny sklon, reziduálnu smerodajnú odchýlku a podiel času pod 8,6 mg/dl alebo nad 10,0 mg/dl. Hospitalizácie a úmrtia následne sledovali počas 90 dní. Do hlavnej analýzy vstúpilo 81 475 pacientov a 431 618 landmarkov; zaznamenali 68 632 hospitalizácií a 12 886 úmrtí. [1]</p>

<p>Posledná hodnota vápnika nebola spojená s hospitalizáciou, bola však spojená s mortalitou. Nižší 180-dňový priemer súvisel najmä s hospitalizáciou, vyšší priemer s úmrtím. Rastúci sklon aj väčšia reziduálna variabilita boli konzistentne spojené s oboma výsledkami. Dlhší čas pod rozmedzím mal odstupňovaný vzťah k hospitalizácii, kým čas nad rozmedzím silno a dávkovo závislo súvisel s mortalitou. [1]</p>

<p>Autori uvádzajú pri väčšej variabilite publikované pomery rizík 1,15 pre hospitalizáciu a 1,37 pre úmrtie; pri rastúcom sklone 1,10 a 1,38. Tieto odhady patria ku konkrétnej parametrizácii modelu a nemožno ich preniesť na ľubovoľný rozdiel kalciémie u jednotlivého pacienta. Pridanie dynamických ukazovateľov navyše zlepšilo diskriminačnú schopnosť populačného modelu iba mierne. [1]</p>

<h3>Čo znamená landmarková analýza</h3>

<p>Landmarkový prístup oddeľuje obdobie merania expozície od následného obdobia sledovania výsledkov. V tejto štúdii bol každý landmark podmienený najmenej štyrmi mesiacmi s dostupným meraním počas predchádzajúcich 180 dní a aspoň jedným meraním v posledných 45 dňoch. Pacient mohol prispieť viacerými landmarkmi, pokiaľ zostával v riziku.</p>

<p>Tento dizajn znižuje niektoré problémy časového usporiadania, neodstraňuje však reziduálne skreslenie ani selekciu pacientov, ktorí sa do landmarku dostali a mali dostatok údajov. Mesačné merania nezachytili krátke výkyvy, ionizovaný vápnik nebol dostupný a albumínom korigovaný vápnik sa použil iba v analýzach citlivosti. Deväťdesiatdňový horizont navyše nehodnotí dlhodobé dôsledky. [1]</p>

<h2>Kalciémia nie je celková vápniková bilancia</h2>

<p>Sérová koncentrácia vápnika je prísne regulovaná a nevyjadruje priamo množstvo vápnika v organizme. Normálna kalciémia preto nevylučuje pozitívnu vápnikovú bilanciu ani ukladanie vápnika mimo kostí. Pri hemodialýze do bilancie vstupujú príjem v potrave a liekoch, črevná absorpcia ovplyvnená vitamínom D, výmena medzi extracelulárnym priestorom a kosťou, prenos počas dialýzy a prípadné reziduálne vylučovanie obličkami.</p>

<p>Najmä pri nízkom kostnom obrate môže byť schopnosť kostry prijímať vápnikovú záťaž obmedzená. Samotná „normálna“ sérová hodnota preto nie je dostatočným argumentom na zvyšovanie prísunu vápnika. KDIGO odporúča u dospelých s CKD G3a–G5D vyhýbať sa hyperkalciémii a pri liečbe znižujúcej fosfáty obmedziť dávku kalciových viazačov. [2]</p>

<h2>Hyperkalciémia: hodnotiť liečbu aj kostný obrat</h2>

<p>Pri opakovanej hyperkalciémii treba preveriť kalciové viazače fosfátov, doplnky vápnika, kalcitriol a analógy vitamínu D, kalcimimetiká, koncentráciu vápnika v dialyzáte aj časový vzťah k zmenám liečby. Výsledok sa interpretuje spolu s PTH, fosfatémiou a dostupnými ukazovateľmi kostného obratu.</p>

<p>Hyperkalciémia pri výrazne zvýšenom PTH vyvoláva iné otázky než hyperkalciémia pri dlhodobo nízkom PTH a podozrení na adynamickú kostnú chorobu. PTH však nie je priamym histologickým vyšetrením kosti. Pri nevysvetlenej alebo výraznej odchýlke treba zvážiť aj príčiny, ktoré nesúvisia priamo s CKD-MBD alebo dialyzačnou liečbou.</p>

<h2>Hypokalciémia: laboratórny nález verzus klinické ohrozenie</h2>

<p>Nízky celkový vápnik pri hypoalbuminémii nie je automaticky indikáciou na suplementáciu. Pri skutočnej hypokalciémii sa hodnotia príznaky, rýchlosť vzniku, ionizovaný vápnik, magnézium, fosfáty, PTH a aktuálna liečba. Dôležitá je súvislosť s kalcimimetikom, nedávnou paratyreoidektómiou alebo inou zmenou metabolického stavu.</p>

<p>KDIGO pripúšťa u dospelých tolerovanie miernej asymptomatickej hypokalciémie, napríklad pri kalcimimetickej liečbe, ak sa tým predíde neprimeranej vápnikovej záťaži. Toto odporúčanie nemožno vzťahovať na symptomatickú alebo závažnú hypokalciémiu. Tetánia, kŕče, významné predĺženie QT intervalu alebo arytmia vyžadujú urgentné klinické posúdenie. [2]</p>

<h2>Dialyzát a načasovanie odberu</h2>

<p>Koncentrácia vápnika v dialyzáte ovplyvňuje prenos medzi krvou a dialyzačným roztokom. Čistú bilanciu však neurčuje iba rozdiel medzi koncentráciou v dialyzáte a celkovou kalciémiou; záleží aj na ionizovanej frakcii, ultrafiltrácii a priebehu procedúry. Vyšší vápnik v dialyzáte môže podporiť hemodynamickú stabilitu, ale zvýšiť vápnikovú záťaž. Nižšia koncentrácia môže záťaž obmedziť, no u citlivého pacienta zhoršiť hypokalciémiu alebo obehovú toleranciu.</p>

<p>KDIGO pri CKD G5D odporúča dialyzát s vápnikom 1,25–1,50 mmol/l (2,5–3,0 mEq/l), pričom predpis má byť individualizovaný. Hodnoty pod 1,25 mmol/l a vysoké koncentrácie 1,75 mmol/l nemožno používať rutinne bez zváženia rizík. [2]</p>

<p>Na sledovanie trendu sú vhodné porovnateľne načasované odbery. Predialyzačná a bezprostredná postdialyzačná hodnota nie sú zameniteľné; výsledok ovplyvňuje aj zmena pH, objemu plazmy a koncentrácie bielkovín počas výkonu.</p>

<h2>Praktický postup pri zmene kalciémie</h2>

<div class="table-responsive" role="region" aria-label="Praktické hodnotenie zmien kalciémie pri hemodialýze" tabindex="0">
<table>
  <thead><tr><th scope="col">Nález</th><th scope="col">Čo preveriť pred úpravou dlhodobej liečby</th></tr></thead>
  <tbody>
    <tr><th scope="row">Nový pokles celkového vápnika</th><td>Albumín, pH, príznaky, opakovanie odberu a potrebu merania ionizovaného vápnika</td></tr>
    <tr><th scope="row">Opakovaná hyperkalciémia</th><td>Kalciové prípravky, vitamín D a jeho analógy, PTH, fosfáty, dialyzát a mimorenálne príčiny</td></tr>
    <tr><th scope="row">Výrazné kolísanie</th><td>Načasovanie odberov, preanalytiku, hospitalizácie, objemový stav, adherenciu a zmeny liečby</td></tr>
    <tr><th scope="row">Hypokalciémia pri kalcimimetiku</th><td>Závažnosť, príznaky, ionizovaný vápnik, magnézium a pravidlá konkrétneho lieku</td></tr>
    <tr><th scope="row">Nesúlad s klinickým obrazom</th><td>Opakovanie vyšetrenia, analytickú metódu a správnosť odberu; podľa situácie ionizovaný vápnik</td></tr>
  </tbody>
</table>
</div>

<p>Najväčšiu informačnú hodnotu má spoločné zobrazenie kalciémie, albumínu, fosfatémie, PTH a zmien liečby v čase. Cieľom nie je „vyhladiť krivku“ bez ohľadu na príčinu, ale odlíšiť biologický signál od meracej variability a zvoliť zásah, ktorý nezvýši riziko arytmie, nadmernej vápnikovej záťaže ani neprimeraného potlačenia kostného obratu.</p>

<h2>Čo zo štúdie nemožno vyvodiť</h2>

<p>DOPPS je observačný program. Asociácia medzi kalciovou dynamikou a výsledkami nedokazuje, že výkyvy kalciémie spôsobili hospitalizáciu alebo úmrtie. Zápal, malnutrícia, zmena albumínu, zhoršenie celkového stavu či úprava terapie môžu ovplyvniť kalciémiu aj riziko udalosti. Ani rozsiahla štatistická úprava nevylučuje reziduálne skreslenie a reverznú kauzalitu.</p>

<p>Výsledky podporujú longitudinálne hodnotenie, nie nový terapeutický cieľ variability. Kým intervenčné štúdie nepreukážu prínos, nemožno tvrdiť, že samotné zníženie kolísania zlepší prežívanie alebo zníži počet hospitalizácií. Klinické rozhodovanie naďalej vychádza z príčiny odchýlky, symptómov, celého profilu CKD-MBD a bezpečnosti liečby.</p>

<h2>Záver</h2>

<p>Jediný výsledok kalciémie pri hemodialýze zachytáva iba jeden časový bod. Priemer, trend, čas mimo rozmedzia a nestabilita môžu odhaliť informáciu, ktorú izolovaná hodnota nezachytí. Zmysluplná interpretácia však vyžaduje porovnateľné odbery, znalosť albumínu a acidobázického stavu, súbežné hodnotenie fosfátov a PTH a presný prehľad dialyzačného predpisu a liečby.</p>

<hr>

<p><em><strong>Literatúra</strong></em></p>
<ol>
  <li><em>Iseri K, Yamazaki T, Taki I, Hida N. Serum calcium dynamics and risk of all-cause hospitalization and mortality in hemodialysis patients: a landmark analysis from the international DOPPS. Clinical Kidney Journal. 2026;19(10):sfag324. DOI: <a href="https://doi.org/10.1093/ckj/sfag324" target="_blank" rel="noopener noreferrer">10.1093/ckj/sfag324</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/42824348/" target="_blank" rel="noopener noreferrer">42824348</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13627834/" target="_blank" rel="noopener noreferrer">plný text</a>.</em></li>
  <li><em>KDIGO 2017 Clinical Practice Guideline Update for CKD–Mineral and Bone Disorder. Kidney International Supplements. 2017;7:1–59. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6340919/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></li>
  <li><em>Clase CM, Norman GL, Beecroft ML, Churchill DN. Albumin-corrected calcium and ionized calcium in stable haemodialysis patients. Nephrology Dialysis Transplantation. 2000;15(11):1841–1846. DOI: <a href="https://doi.org/10.1093/ndt/15.11.1841" target="_blank" rel="noopener noreferrer">10.1093/ndt/15.11.1841</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/11071975/" target="_blank" rel="noopener noreferrer">11071975</a>.</em></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_dynamika_kalciemie_hemodialyza',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];
$total       = count($articles);

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
            <div class="alert alert-error"><ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul></div>
          <?php endif; ?>
          <div class="alert <?= ($inserted + $updated) > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> vložených, <?= $updated ?> aktualizovaných z <?= $total ?> článkov. <?= $skipped ?> bez zmeny.</p>
            <?php if ($queuedTotal > 0): ?><p>Do fronty avíz zaradených: <strong><?= $queuedTotal ?></strong> e-mailov.</p><?php endif; ?>
          </div>
          <ul><?php foreach ($articles as $a): ?><li><strong><?= htmlspecialchars($a['title']) ?></strong> (slug: <code><?= htmlspecialchars($a['slug']) ?></code>)</li><?php endforeach; ?></ul>
          <p class="mt-30"><a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a>&nbsp; <a href="admin_articles.php" class="btn-secondary-small">Správa článkov</a></p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
