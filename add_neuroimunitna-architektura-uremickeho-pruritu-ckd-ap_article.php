<?php

/**
 * add_neuroimunitna-architektura-uremickeho-pruritu-ckd-ap_article.php
 * Neuroimunitna architektura uremickeho pruritu (CKD-aP) - model styroch uzlov.
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
    'title'        => 'Neuroimunitná architektúra uremického pruritu: model štyroch uzlov a jeho terapeutické dôsledky',
    'slug'         => 'neuroimunitna-architektura-uremickeho-pruritu-ckd-ap',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Pruritus pri chronickej chorobe obličiek trápi vyše tretinu dialyzovaných pacientov a liečba býva empirická. Nový prehľad navrhuje model štyroch neuroimunitných uzlov, ktorý vysvetľuje, prečo antihistaminiká zlyhávajú a prečo gabapentinoidy a difelikefalín zaberajú.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Svrbenie pri chronickej chorobe obličiek nemá jednu dominantnú príčinu — a práve preto naň zlyháva liečba postavená na jednom mechanizme. Brazílsky prehľadový článok navrhuje rámec štyroch neuroimunitných uzlov, ktorý mechanistickú zložitosť prekladá do klinicky uchopiteľných domén. Autori ho výslovne označujú za pragmatický a generujúci hypotézy, nie za validovaný systém endotypizácie.</em></p>

<p>Pruritus asociovaný s chronickou chorobou obličiek (v anglickej literatúre <em>CKD-associated pruritus</em>, CKD-aP; staršie „uremický pruritus“) patrí medzi symptómy, ktoré sa v ambulancii ľahko prehliadnu — pacient ich sám nespomenie a lekár sa na ne nespýta. Pritom ide o jeden z najzaťažujúcejších prejavov pokročilého ochorenia obličiek.</p>

<p>Longitudinálna analýza medzinárodnej štúdie DOPPS, ktorá zahrnula 7976 hemodialyzovaných pacientov z 21 krajín, ukazuje, že <strong>51 % pacientov malo stredne ťažké až ťažké svrbenie</strong> aspoň pri jednom z dvoch hodnotení a 22 % pri oboch. Symptóm teda nie je prechodný — u pätiny pacientov pretrváva roky.</p>

<p>Dôsledky nie sú len subjektívne. U pacientov s pretrvávajúcim svrbením boli oproti pacientom bez neho upravené pomery rizík <strong>1,29 (95 % IS 1,09–1,53) pre celkovú mortalitu</strong>, 1,17 (1,07–1,28) pre hospitalizáciu z akejkoľvek príčiny a 1,48 (1,26–1,74) pre kardiovaskulárne príhody. U pacientov, u ktorých sa svrbenie nanovo objavilo, stúpol výskyt depresie o 13 percentuálnych bodov, nepokojného spánku o 10 a pocitu vyčerpania o 14.</p>

<p>Kauzálny výklad je namieste opatrný — svrbenie môže byť sčasti aj ukazovateľom horšieho celkového stavu. Konzistentná súvislosť so spánkom a depresiou však naznačuje pravdepodobnú cestu, ktorou sa symptóm premieta do tvrdých ukazovateľov.</p>

<p>Napriek tomu zostáva manažment CKD-aP prevažne empirický a jeho účinnosť len čiastočná. Prehľad publikovaný v <em>Journal of Nephrology</em> ponúka vysvetlenie, prečo je to tak.</p>

<h2>Prečo jeden mechanizmus nestačí</h2>

<p>Autori pod vedením Lucasa Maciela de Almeidu Corrêu vychádzajú z pozorovania, že patofyziológia CKD-aP nevzniká z jednej dominantnej dráhy, ale zo súhry systémových, kožných, neurálnych a centrálne sprostredkovaných mechanizmov. Do syntézy zahrnuli:</p>

<ul>
  <li>zadržané uremické solúty,</li>
  <li>mikrozápal,</li>
  <li>xerózu a poruchu kožnej bariéry,</li>
  <li>imunitnú dysreguláciu,</li>
  <li>neuropatickú senzitizáciu,</li>
  <li>nerovnováhu opioidných mechanizmov,</li>
  <li>signalizáciu neuropeptidov.</li>
</ul>

<p>Tento zoznam je klinicky nepoužiteľný — je príliš dlhý a jednotlivé položky sa prekrývajú. Autori ho preto zoskupili do štyroch uzlov, ktoré majú byť <strong>organizujúcim modelom</strong>, teda pomôckou na usporiadanie uvažovania, nie klasifikačným systémom.</p>

<h2>Model štyroch uzlov</h2>

<h3>Uzol I: periférna neuroimunitná synapsa</h3>

<p>Miesto, kde sa v koži stretávajú zakončenia senzitívnych C-vlákien s keratinocytmi, mastocytmi a bunkami imunitného systému. Tu sa spája niekoľko vplyvov naraz: porucha kožnej bariéry pri xeróze, lokálna zápalová aktivita a účinok zadržaných uremických solútov. Výsledkom je pruritogénna signalizácia, ktorá vzniká ešte pred vstupom do nervového systému.</p>

<p>Klinickým korelátom tohto uzla je suchá koža — nález, ktorý má u dialyzovaných pacientov vysokú prevalenciu a ktorý je zároveň jediným plne modifikovateľným článkom celého reťazca. Sústavná lokálna starostlivosť s emoliens patrí preto na začiatok liečby vždy, aj keď je jej samostatný účinok obmedzený.</p>

<h3>Uzol II: nervový prenos a hyperexcitabilita</h3>

<p>Uzol zahŕňa prenos pruritogénneho signálu periférnym a centrálnym nervovým systémom a jeho patologické zosilnenie. Opakovaná alebo dlhodobá stimulácia vedie k zníženiu prahu a k senzitizácii — svrbenie sa udržiava aj po tom, ako pôvodný podnet zoslabne.</p>

<p>Práve tento uzol dáva mechanistický zmysel účinnosti <strong>gabapentinoidov</strong>. Gabapentín a pregabalín pôsobia na podjednotku α2δ napäťovo riadených kalciových kanálov a tlmia neuronálnu hyperexcitabilitu. Pri dialýze sa dávkujú výrazne redukovane, spravidla v malých dávkach po dialyzačnej procedúre; oba sa eliminujú obličkami a pri bežnom dávkovaní kumulujú, s rizikom sedácie, závratov, porúch chôdze a pádov. Ide o typický príklad liečby, kde je rozdiel medzi účinnou a toxickou dávkou u dialyzovaného pacienta úzky.</p>

<h3>Uzol III: centrálna opioidná modulácia</h3>

<p>Uzol vychádza z dlhšie diskutovanej hypotézy o nerovnováhe opioidného systému: relatívnej prevahe aktivity μ-receptorov, ktorá svrbenie podporuje, nad aktivitou κ-receptorov, ktorá ho tlmí.</p>

<p>Tento uzol je terapeuticky najlepšie doložený. <strong>Difelikefalín</strong>, periférne obmedzený agonista κ-opioidných receptorov, bol v štúdiách KALM-1 a KALM-2 podávaný intravenózne v dávke 0,5 µg/kg po každej hemodialýze počas 12 týždňov. V združenej analýze oboch štúdií dosiahlo pokles najhoršej intenzity svrbenia (WI-NRS) aspoň o 3 body <strong>51,1 % pacientov oproti 35,2 %</strong> pri placebe; pokles aspoň o 4 body dosiahlo 38,7 % oproti 23,4 %. Rozdiel je konzistentný, no zároveň je namieste všimnúť si vysokú odpoveď v ramene s placebom — pri subjektívnom symptóme, akým je svrbenie, ide o očakávaný jav, ktorý pripomína, aký veľký podiel má na hodnotení symptómu očakávanie pacienta.</p>

<p>V Japonsku sa v rovnakej indikácii dlhodobo používa nalfurafín, ďalší agonista κ-receptorov.</p>

<h3>Uzol IV: amplifikácia cez substanciu P a NK-1</h3>

<p>Neuropeptidový okruh, v ktorom substancia P uvoľňovaná z nervových zakončení pôsobí na receptor neurokinínu 1 (NK-1) a spätne zosilňuje periférnu aj centrálnu pruritogénnu signalizáciu. Uzol vysvetľuje, prečo sa svrbenie môže udržiavať samo od seba, aj keď sa pôvodný spúšťač nezmenil.</p>

<p>Terapeuticky je táto doména zatiaľ najmenej rozvinutá. Antagonisty NK-1 boli pri chronickom pruríte skúšané, výsledky štúdií však boli nekonzistentné a pre CKD-aP nejde o etablovanú liečbu. Tento uzol treba čítať predovšetkým ako hypotézu smerujúcu k ďalšiemu výskumu.</p>

<h2>Prečo antihistaminiká sklamú</h2>

<p>Model dobre vysvetľuje jednu z najčastejších klinických skúseností: obmedzenú účinnosť antihistaminík. Ani jeden zo štyroch uzlov nie je primárne histamínový. Histamín je pri CKD-aP nanajvýš okrajovým mediátorom a blokáda H<sub>1</sub>-receptorov preto nezasahuje do hlavných dráh.</p>

<p>Zlepšenie, ktoré pacienti po antihistaminikách niekedy uvádzajú, sa dá vo veľkej miere pripísať <strong>sedatívnemu účinku</strong> — pacient lepšie spí a svrbenie subjektívne menej vníma. U dialyzovaného, spravidla staršieho pacienta ide o problematickú cestu: sedatívne antihistaminiká majú anticholinergné pôsobenie a zvyšujú riziko zmätenosti a pádov. Ich dlhodobé podávanie ako „liečby svrbenia“ je preto ťažko obhájiteľné.</p>

<h2>Čo model neznamená</h2>

<p>Autori formulujú svoje obmedzenia neobvykle jasne a je vhodné ich neprekročiť. Model je označený za <strong>pragmatický a generujúci hypotézy</strong>, výslovne nie za validovaný systém endotypizácie. To znamená:</p>

<ul>
  <li>pacienta nemožno zaradiť do konkrétneho uzla nijakým overeným testom;</li>
  <li>neexistuje dôkaz, že priradenie k uzlu predpovedá odpoveď na zodpovedajúcu liečbu;</li>
  <li>uzly sa v praxi prekrývajú a u jedného pacienta pôsobia pravdepodobne súčasne;</li>
  <li>voľba liečby podľa predpokladaného mechanizmu si pred zavedením do rutinnej praxe vyžaduje prospektívnu validáciu.</li>
</ul>

<p>Ide teda o didaktický a výskumný rámec. Jeho hodnota je v tom, že usporadúva myslenie a navrhuje smer pre budúce štúdie s obohatením súboru — teda štúdie, ktoré zaradia práve tých pacientov, u ktorých má testovaný mechanizmus najväčšiu pravdepodobnosť uplatnenia. Doterajšie štúdie liečili heterogénnu populáciu jednotne, čo mohlo skutočný účinok rozriediť.</p>

<h2>Praktický postup pri pacientovi so svrbením</h2>

<p>Aj bez validovanej endotypizácie z modelu vyplýva zmysluplná postupnosť krokov:</p>

<ol>
  <li><strong>Aktívne sa pýtať.</strong> Pacienti svrbenie často nespomenú, lebo ho považujú za nevyhnutnú súčasť ochorenia. Na kvantifikáciu postačí jednoduchá číselná škála najhoršej intenzity za posledných 24 hodín (WI-NRS), prípadne 5-D škála svrbenia.</li>
  <li><strong>Vylúčiť iné príčiny.</strong> Liekové exantémy, cholestáza, ochorenia štítnej žľazy, hematologické ochorenia, scabies a primárne dermatologické diagnózy sa nesmú prehliadnuť len preto, že pacient je dialyzovaný.</li>
  <li><strong>Ošetriť kožnú bariéru.</strong> Emoliens dôsledne a dlhodobo, obmedzenie horúcich sprch a dráždivých mydiel. Nízka cena a nulové riziko ospravedlňujú tento krok u každého pacienta.</li>
  <li><strong>Optimalizovať to, čo je optimalizovateľné.</strong> Dialyzačná dávka, minerálový a kostný metabolizmus a hydratácia kože patria k základu, hoci dôkazy o ich vplyve práve na svrbenie sú slabšie, než sa tradične predpokladalo.</li>
  <li><strong>Pri pretrvávajúcom stredne ťažkom až ťažkom svrbení zvážiť cielenú liečbu.</strong> Gabapentinoid v redukovanej dávke alebo difelikefalín tam, kde je dostupný. Odpoveď hodnotiť tou istou škálou, akou sa hodnotil východiskový stav.</li>
  <li><strong>Nezabudnúť na spánok a psychiku.</strong> Vzťah medzi svrbením, nespavosťou a depresiou je obojsmerný a liečba len jednej zložky býva neúspešná.</li>
</ol>

<h2>Poznámka k dostupnosti</h2>

<p>Difelikefalín je registrovaný v USA (Korsuva) aj v Európskej únii (Kapruvia) na liečbu stredne ťažkého až ťažkého CKD-aP u dospelých hemodialyzovaných pacientov. Skutočná dostupnosť a úhrada sa však medzi krajinami líšia a v praxi býva hlavným obmedzením. Gabapentinoidy zostávajú preto v mnohých prostrediach pragmatickou prvou voľbou pri farmakologickej liečbe — s vedomím, že ide o použitie mimo registrovanej indikácie a s dôrazom na nízke dávkovanie.</p>

<h2>Záver</h2>

<p>Prehľad neprináša nový liek ani nové dáta o účinnosti. Prináša niečo iné a v tomto prípade užitočné: usporiadanie rozptýlených mechanizmov do štyroch domén, ktoré sa dajú spojiť s konkrétnymi liečebnými zásahmi. Vysvetľuje, prečo antihistaminiká pri CKD-aP zlyhávajú, prečo gabapentinoidy a difelikefalín zaberajú, a prečo je pravdepodobné, že žiadna monoterapia nebude fungovať u všetkých.</p>

<p>Zároveň si zachováva korektnú mieru: ide o rámec na uvažovanie a plánovanie výskumu, nie o návod na výber liečby podľa mechanizmu. Prospektívna validácia je podmienkou, ktorú autori sami stanovujú — a bolo by chybou ju pri čítaní preskočiť.</p>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Lucas Maciel de Almeida Corrêa, Letícia Esteves Dante, Laura de Azevedo Catenaccio, Thifanny Rodrigues de Oliveira, Beatriz Cossini Bonavita Martins, Luiggi Kevin Virgino Brandão, Alexandre de Assis Barbosa, Gabriel Costa de Santana.</strong> <em>The neuroimmune architecture of uremic pruritus: mechanisms and therapeutic targeting.</em> Journal of Nephrology. 2026 Aug 3 (online ahead of print). doi: 10.1093/joneph/aajag135. <a href="https://pubmed.ncbi.nlm.nih.gov/42544762/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1093/joneph/aajag135" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Steven Fishbane, Aamir Jamal, Catherine Munera, Warren Wen, Frédérique Menzaghi; KALM-1 Trial Investigators.</strong> <em>A Phase 3 Trial of Difelikefalin in Hemodialysis Patients with Pruritus.</em> New England Journal of Medicine. 2020;382(3):222–232. doi: 10.1056/NEJMoa1912770. <a href="https://pubmed.ncbi.nlm.nih.gov/31702883/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Joel Topf, Thomas Wooldridge, Kieran McCafferty, Michael Schömig, Botond Csiky, Rafal Zwiech, Warren Wen, Sarbani Bhaduri, Catherine Munera, Rong Lin, Alia Jebara, Joshua Cirulli, Frédérique Menzaghi.</strong> <em>Efficacy of Difelikefalin for the Treatment of Moderate to Severe Pruritus in Hemodialysis Patients: Pooled Analysis of KALM-1 and KALM-2 Phase 3 Studies.</em> Kidney Medicine. 2022;4(8):100512. doi: 10.1016/j.xkme.2022.100512. <a href="https://pubmed.ncbi.nlm.nih.gov/36016762/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Nidhi Sukul, Junhui Zhao, Ronald L. Pisoni, Sebastian Walpen, Thilo Schaufler, Elham Asgari, Fitsum Guebre-Egziabher, Li Zuo, Mohammed Abdulrahman Al-Ghonaim, Kosaku Nitta, Bruce M. Robinson, Angelo Karaboyas.</strong> <em>Pruritus in Hemodialysis Patients: Longitudinal Associations With Clinical and Patient-Reported Outcomes.</em> American Journal of Kidney Diseases. 2023;82(6):666–676. doi: 10.1053/j.ajkd.2023.04.008. <a href="https://pubmed.ncbi.nlm.nih.gov/37777951/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Hector Alvarado Verduzco, Shayan Shirazian.</strong> <em>CKD-Associated Pruritus: New Insights Into Diagnosis, Pathogenesis, and Management.</em> Kidney International Reports. 2020;5(9):1387–1402. doi: 10.1016/j.ekir.2020.04.027. <a href="https://www.kireports.org/article/S2468-0249(20)31230-4/fulltext" target="_blank" rel="noopener noreferrer">KI Reports</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Hlavným spracovaným zdrojom je prehľadový článok Corrêu a spolupracovníkov; jeho bibliografické údaje, kompletné autorstvo aj znenie abstraktu vrátane názvov všetkých štyroch uzlov a výslovného obmedzenia „pragmatický a generujúci hypotézy, nie validovaný systém endotypizácie“ boli overené v PubMed a Europe PMC. Plný text prehľadu je za platobnou bariérou vydavateľa a nebol sprístupnený; opis jednotlivých uzlov preto vychádza z abstraktu a z etablovanej patofyziológie, nie z detailnej argumentácie autorov. Epidemiologické údaje (51 % a 22 % v DOPPS, pomery rizík pre mortalitu, hospitalizáciu a kardiovaskulárne príhody) a výsledky štúdií KALM-1 a KALM-2 (51,1 % oproti 35,2 % pri poklese WI-NRS aspoň o 3 body) pochádzajú z uvedených samostatných zdrojov, boli overené v Europe PMC a v pôvodnom prehľade sa v tejto podobe neuvádzajú. Praktický postup, poznámky o dávkovaní gabapentinoidov pri dialýze a komentár k sedatívnemu účinku antihistaminík sú <strong>vlastným odborným spracovaním</strong>.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_neuroimunitna-architektura-uremickeho-pruritu-ckd-ap_article',
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
