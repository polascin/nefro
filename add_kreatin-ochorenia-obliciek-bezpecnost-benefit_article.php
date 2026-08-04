<?php

/**
 * add_kreatin-ochorenia-obliciek-bezpecnost-benefit_article.php
 * Kriticka klinicka synteza o kreatine pri ochoreniach obliciek.
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
    'title'        => 'Kreatín pri ochoreniach obličiek: škoda, prínos alebo diagnostická pasca?',
    'slug'         => 'kreatin-ochorenia-obliciek-bezpecnost-benefit',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kontrolované štúdie u ľudí bez CKD sú prevažne upokojujúce, pri etablovanej chorobe obličiek však chýbajú spoľahlivé dlhodobé údaje. Kreatín môže navyše skresliť kreatinínovú eGFR.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Kreatín môže zvýšiť sérový kreatinín bez skutočného poklesu glomerulovej filtrácie. Z toho však nevyplýva, že každý vzostup kreatinínu počas suplementácie je neškodný ani že bezpečnostné údaje zo zdravých dospelých možno automaticky preniesť na pacientov s chronickou chorobou obličiek. Klinicky rozhoduje kontext, viacmarkerové hodnotenie a poctivé priznanie neistoty.</em></p>

<p>Kreatín patrí medzi najpoužívanejšie výživové doplnky. Jeho účinok na krátkodobý výkon pri vysokej intenzite a na prírastok svalovej hmoty pri odporovom tréningu je dobre preskúmaný. Záujem sa preto rozšíril aj na starnutie, sarkopéniu, kognitívne poruchy a chronické ochorenia. Práve v týchto populáciách je však častá chronická choroba obličiek (CKD), pri ktorej máme podstatne menej údajov než u mladých zdravých účastníkov športových štúdií.</p>

<p>Naratívny prehľad, ktorý v roku 2026 publikovali Juliana Paula Pereira a spoluautori v časopise <em>Nephrology Dialysis Transplantation</em>, sumarizuje možné prínosy aj riziká kreatínu pri ochoreniach obličiek. Jeho závery sú biologicky podnetné, ale pre klinické rozhodovanie treba oddeliť dôkazy o laboratórnych ukazovateľoch od dôkazov o dlhodobej bezpečnosti a od hypotéz o liečebnom prínose.</p>

<h2>Kreatín nie je kreatinín</h2>

<p>Kreatín a fosfokreatín tvoria energetický pufrovací systém buniek, najmä vo svaloch a v tkanivách s rýchlo sa meniacou spotrebou energie. Časť telesného kreatínového poolu sa neenzýmovo a ireverzibilne premieňa na kreatinín. Kreatinín sa následne vylučuje prevažne obličkami a jeho sérová koncentrácia závisí od rovnováhy medzi tvorbou a elimináciou.</p>

<p>Po suplementácii sa môže zväčšiť telesný pool kreatínu, a tým aj množstvo vznikajúceho kreatinínu. Sérový kreatinín preto môže stúpnuť aj bez skutočného poklesu glomerulovej filtrácie. Keďže eGFR odvodená od kreatinínu predpokladá relatívne stabilnú tvorbu kreatinínu, môže sa vypočítaná eGFR zdanlivo znížiť.</p>

<p>Nejde o analytickú interferenciu laboratórnej metódy v užšom zmysle. Kreatinín je reálne zvýšený, ale jeho zmena nemusí byť spôsobená zhoršenou filtráciou. Presnejšie je hovoriť o <strong>determinante kreatinínu nezávislom od GFR</strong> alebo o fyziologickom skreslení kreatinínového odhadu GFR.</p>

<h2>Čo ukazujú kontrolované štúdie</h2>

<p>Nová metaanalýza randomizovaných štúdií Tsiarasa a spoluautorov zahrnula 19 randomizovaných kontrolovaných štúdií a jednu dvojito zaslepenú randomizovanú krížovú štúdiu. Kreatín bol spojený s priemerným zvýšením sérového kreatinínu o 0,13 mg/dl (95 % interval spoľahlivosti 0,07–0,18). Medzi skupinami sa však nepreukázal štatisticky významný rozdiel v močovine ani v eGFR.</p>

<p>Tento výsledok je upokojujúci, ale nie definitívny. eGFR bola hodnotená iba v ôsmich zahrnutých štúdiách a môže byť sama odvodená od kreatinínu, teda od markera ovplyvneného intervenciou. Autori navyše upozorňujú na potrebu randomizovaných štúdií dlhších ako jeden rok. Neprítomnosť štatisticky významného rozdielu preto nie je dôkazom nulového rizika vo všetkých populáciách.</p>

<p>Systematický prehľad a metaanalýza Kabiri Naeini a spoluautorov z roku 2025 dospeli k podobnému záveru: malé zvýšenie kreatinínu bez preukázaného významného poklesu GFR. Aj táto analýza však zahŕňala malé a heterogénne štúdie, prevažne s krátkym sledovaním. Upokojujúci bezpečnostný profil u zdravých alebo starostlivo vybraných účastníkov nemožno zameniť za dôkaz bezpečnosti pri pokročilej CKD.</p>

<h2>Zdravé obličky a CKD sú dve rozdielne otázky</h2>

<p>Najpresvedčivejšie bezpečnostné údaje sa týkajú kreatínmonohydrátu u osôb bez známeho ochorenia obličiek. Štúdie často používajú udržiavacie dávky približne 3–5 g denne; niektoré protokoly začínajú krátkou nasycovacou fázou. Tieto režimy však nemožno bez ďalších údajov považovať za overené dávkovanie pre CKD.</p>

<p>Pri etablovanej CKD zostávajú podstatné medzery:</p>

<ul>
  <li>málo účastníkov s jednoznačne charakterizovaným ochorením obličiek,</li>
  <li>nedostatok dlhodobých randomizovaných štúdií v jednotlivých G kategóriách CKD,</li>
  <li>málo výsledkov založených na meranej GFR, cystatíne C, albuminúrii a klinických udalostiach,</li>
  <li>nedostatočné údaje pri nestabilnej funkcii obličiek, po transplantácii a pri súčasnej nefrotoxickej expozícii,</li>
  <li>obmedzená prenositeľnosť údajov medzi kreatínmonohydrátom a inými komerčnými formami alebo zmesami.</li>
</ul>

<p>Kreatín preto nemožno v súčasnosti odporúčať ako štandardnú liečbu CKD ani ako rutinnú terapiu renálnej sarkopénie. Zároveň nie je podložené tvrdenie, že každá expozícia kreatínu pri stabilnej CKD automaticky spôsobí poškodenie obličiek. Ide o oblasť pre individuálne rozhodovanie, nie pre univerzálny zákaz alebo univerzálne odporúčanie.</p>

<h2>Potenciálny prínos: zaujímavý, ale zatiaľ nepreukázaný</h2>

<p>Pacienti s CKD majú vysoké riziko sarkopénie, krehkosti a zníženej fyzickej výkonnosti. Kreatín má v kombinácii s odporovým tréningom biologicky aj klinicky plausibilný potenciál podporiť svalovú funkciu. Dôkazy zo všeobecnej populácie však nie sú náhradou za štúdie u pacientov s CKD, ktorí majú odlišnú homeostázu, komorbidity, farmakoterapiu aj nutričné obmedzenia.</p>

<p>V exploratívnej dvojito zaslepenej štúdii u hemodialyzovaných pacientov sa počas jedného roka podávalo 5 g kreatínmonohydrátu denne. V kreatínovej skupine sa zvýšila beztuková hmota a index kostrového svalstva hodnotené bioimpedanciou, skóre malnutrície a zápalu sa však nezlepšilo. Súčasne vzrástla celková aj intracelulárna voda. Časť zdanlivého zlepšenia telesného zloženia preto mohla súvisieť s hydratáciou a výsledok nemožno interpretovať ako definitívny dôkaz nárastu kontraktilnej svalovej hmoty alebo klinického prínosu.</p>

<p>Úvahy o neuroprotekcii, protizápalovom účinku, oxidačnom strese a črevnej bariére sú zaujímavé, ale pri CKD zostávajú prevažne mechanistické alebo extrapolované z iných populácií. Zatiaľ neposkytujú podklad na rutinnú preskripciu kreatínu na kognitívne ťažkosti, zápal alebo dysbiózu pri CKD.</p>

<h2>Vzostup kreatinínu nemožno automaticky bagatelizovať</h2>

<p>Ak sa po začatí kreatínu zvýši sérový kreatinín, existujú najmenej tri možnosti: zvýšená tvorba kreatinínu bez zmeny GFR, skutočné akútne poškodenie obličiek alebo kombinácia oboch. Samotná časová súvislosť nerozhodne, o ktorý mechanizmus ide.</p>

<p>Pre skutočné poškodenie obličiek hovoria najmä sprievodné klinické alebo laboratórne odchýlky:</p>

<ul>
  <li>oligúria, opuchy, hypotenzia alebo známky dehydratácie,</li>
  <li>nová alebo rastúca albuminúria či proteinúria, hematúria alebo aktívny močový sediment,</li>
  <li>hyperkaliémia, metabolická acidóza alebo progresívny vzostup močoviny,</li>
  <li>súbežná infekcia, vracanie, hnačka, extrémna fyzická záťaž alebo rabdomyolýza,</li>
  <li>užívanie NSAID, anabolických steroidov, neregulovaných zmesí alebo iných potenciálne nefrotoxických látok,</li>
  <li>paralelný pokles eGFR odvodenej od cystatínu C alebo nepriaznivá zmena meranej GFR.</li>
</ul>

<p>Naopak, izolovaný stabilný vzostup kreatinínu bez albuminúrie, bez patologického sedimentu, bez poruchy vnútorného prostredia a bez poklesu cystatínovej alebo meranej GFR podporuje vysvetlenie nezávislé od zmeny GFR. Ani tento obraz však nenahrádza klinické posúdenie.</p>

<h2>Cystatín C pomáha, ale nie je neomylný</h2>

<p>KDIGO 2024 odporúča pri dostupnosti cystatínu C používať na kategorizáciu GFR kombinovanú rovnicu z kreatinínu a cystatínu C. Pri situáciách, v ktorých je kreatinín ovplyvnený iným faktorom než GFR, môže byť cystatínová alebo kombinovaná eGFR informatívnejšia.</p>

<p>Cystatín C však tiež ovplyvňujú faktory nezávislé od GFR, napríklad glukokortikoidy, poruchy štítnej žľazy, zápal, fajčenie a telesná kompozícia. Rozdiel medzi eGFR z kreatinínu a z cystatínu C preto treba interpretovať, nie mechanicky vybrať „lepšie“ číslo. Ak od presnosti závisí významné rozhodnutie, napríklad dávkovanie lieku s úzkym terapeutickým oknom alebo zaradenie do liečby, má sa zvážiť meraná GFR.</p>

<h2>Praktický postup pred začatím suplementácie pri CKD</h2>

<ol>
  <li><strong>Ujasniť cieľ.</strong> Výkonnostný cieľ, liečba sarkopénie a neurčitá predstava o „energii“ majú odlišnú očakávanú hodnotu. Pri CKD nejde o nefroprotektívnu liečbu.</li>
  <li><strong>Charakterizovať riziko.</strong> Zhodnotiť G kategóriu a albuminúriu, trend funkcie obličiek, predchádzajúce AKI, krvný tlak, objemový stav, diabetes, srdcové zlyhávanie, transplantáciu a súbežnú liečbu.</li>
  <li><strong>Zaznamenať východiskový stav.</strong> Minimálne kreatinín/eGFR, uACR alebo inú primeranú kvantifikáciu proteinúrie a močový nález; podľa klinickej potreby cystatín C, elektrolyty a močovinu.</li>
  <li><strong>Presne zapísať prípravok.</strong> Väčšina údajov sa týka čistého kreatínmonohydrátu. Zloženie viaczložkových produktov, stimulantov a neregulovaných zmesí môže byť nejasné.</li>
  <li><strong>Dohodnúť monitorovanie a pravidlá prerušenia.</strong> Pri CKD neexistuje univerzálne validovaný protokol ani dávka. Kontrola má zohľadniť východiskové riziko, stabilitu ochorenia a význam rozhodnutia.</li>
</ol>

<p>Pacient s akútnym poškodením obličiek, rýchlo sa meniacim kreatinínom, dekompenzovaným srdcovým zlyhávaním, výraznou objemovou poruchou alebo nevysvetleným aktívnym močovým nálezom nemá začínať suplementáciu bez vyriešenia akútneho problému. Pri pokročilej CKD, po transplantácii alebo pri súbežnej potenciálne nefrotoxickej liečbe má rozhodnutie prebehnúť s nefrológom.</p>

<h2>Čo urobiť pri neočakávanom vzostupe kreatinínu</h2>

<ol>
  <li><strong>Nepredpokladať vopred benignitu ani toxicitu.</strong> Overiť časový priebeh, dávku, formu prípravku, adherenciu a všetky súbežné doplnky a lieky.</li>
  <li><strong>Hľadať AKI a jeho spúšťače.</strong> Posúdiť objemový stav, krvný tlak, diurézu, interkurentné ochorenie, fyzickú záťaž a podľa situácie kreatínkinázu.</li>
  <li><strong>Doplniť poškodenie obličiek.</strong> Vyšetriť moč, albuminúriu alebo proteinúriu, elektrolyty a acidobázický stav.</li>
  <li><strong>Použiť nezávislejší odhad GFR.</strong> Ak je dostupný, doplniť cystatín C a kombinovanú eGFRcr-cys; pri zásadnom rozhodnutí zvážiť meranú GFR.</li>
  <li><strong>Zvážiť dočasné prerušenie.</strong> Kontrolované vysadenie s opakovaným meraním môže pomôcť objasniť príspevok suplementácie, nesmie však oddialiť diagnostiku skutočného AKI.</li>
</ol>

<h2>Čo možno a nemožno uzavrieť</h2>

<ul>
  <li><strong>Možno:</strong> kreatínmonohydrát v skúmaných dávkach u prevažne zdravých alebo starostlivo vybraných účastníkov nepreukázal konzistentné zhoršenie GFR.</li>
  <li><strong>Možno:</strong> suplementácia môže zvýšiť sérový kreatinín a znížiť kreatinínovú eGFR bez skutočnej zmeny filtrácie.</li>
  <li><strong>Nemožno:</strong> každý vzostup kreatinínu pripísať suplementu a bez ďalšieho hodnotenia vylúčiť AKI.</li>
  <li><strong>Nemožno:</strong> považovať dlhodobú bezpečnosť za preukázanú vo všetkých štádiách CKD, po transplantácii alebo pri nestabilnej funkcii obličiek.</li>
  <li><strong>Nemožno:</strong> odporúčať kreatín ako nefroprotektívnu liečbu alebo ako štandardnú terapiu sarkopénie, kognitívnych ťažkostí či črevnej dysfunkcie pri CKD.</li>
</ul>

<h2>Limity dostupných dôkazov</h2>

<ul>
  <li><strong>Primárny zdroj je naratívny prehľad:</strong> integruje mechanistické, experimentálne aj klinické údaje, ale nemá metodiku jednej kvantitatívnej syntézy.</li>
  <li><strong>Krátke a malé štúdie:</strong> veľká časť bezpečnostných údajov nepresahuje niekoľko mesiacov a nie je navrhnutá na zachytenie zriedkavých renálnych udalostí.</li>
  <li><strong>Málo CKD dát:</strong> populácie s pokročilou alebo nestabilnou CKD sú nedostatočne zastúpené.</li>
  <li><strong>Nevhodné koncové ukazovatele:</strong> kreatinínová eGFR môže byť ovplyvnená samotným kreatínom; meraná GFR, cystatín C, albuminúria a tvrdé klinické výsledky sa používajú menej často.</li>
  <li><strong>Heterogénne prípravky a kontext:</strong> výsledky čistého kreatínmonohydrátu nemožno automaticky preniesť na iné formy, zmesi, extrémne dávky alebo kombináciu s anabolikami a intenzívnym tréningom.</li>
</ul>

<h2>Záver</h2>

<p>Najlepšie dostupné kontrolované údaje nepodporujú predstavu, že kreatínmonohydrát v bežne skúmaných dávkach u ľudí bez ochorenia obličiek spôsobuje poškodenie obličiek. Zároveň ukazujú, že sérový kreatinín sa môže mierne zvýšiť bez preukázaného poklesu GFR.</p>

<p>Pri CKD je však dôkazová situácia podstatne menej istá. Kreatín nie je štandardnou liečbou CKD a jeho potenciálny svalový, neurokognitívny alebo metabolický prínos v tejto populácii zostáva nedostatočne overený. Rozumný prístup preto spája individuálne posúdenie rizika, znalosť presného prípravku, východiskové vyšetrenie a interpretáciu kreatinínu spolu s močovým nálezom, albuminúriou, cystatínom C a podľa potreby meranou GFR.</p>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Pereira JP, Leal VO, Trigueira P, Borges NA, Cardozo LFMF, Mafra D.</strong> <em>Creatine supplementation in patients with kidney disease – harm or benefit?</em> Nephrology Dialysis Transplantation. 2026;gfag169. doi: 10.1093/ndt/gfag169. <a href="https://pubmed.ncbi.nlm.nih.gov/42545747/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1093/ndt/gfag169" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Tsiaras A, Loufopoulos G, Theodoridis X, et al.</strong> <em>The effect of creatine supplementation on kidney function: a systematic review and meta-analysis of randomized controlled trials.</em> Journal of Renal Nutrition. 2026. doi: 10.1053/j.jrn.2026.04.010. <a href="https://pubmed.ncbi.nlm.nih.gov/42035842/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Kabiri Naeini E, Eskandari M, Mortazavi M, Gholaminejad A, Karevan N.</strong> <em>Effect of creatine supplementation on kidney function: a systematic review and meta-analysis.</em> BMC Nephrology. 2025;26:622. doi: 10.1186/s12882-025-04558-6. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12590749/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Longobardi I, Gualano B, Seguro AC, Roschel H.</strong> <em>Is It Time for a Requiem for Creatine Supplementation-Induced Kidney Failure? A Narrative Review.</em> Nutrients. 2023;15(6):1466. doi: 10.3390/nu15061466. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10054094/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney International. 2024;105(4S):S117–S314. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO</a>.</li>
  <li><strong>Marini ACB, Schincaglia RM, Candow DG, Pimentel GD.</strong> <em>Effect of Creatine Supplementation on Body Composition and Malnutrition-Inflammation Score in Hemodialysis Patients: An Exploratory 1-Year, Balanced, Double-Blind Design.</em> Nutrients. 2024;16(5):615. doi: 10.3390/nu16050615. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10934827/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Hlavným spracovaným zdrojom je naratívny prehľad Pereirovej a spoluautorov. Jeho bibliografické údaje a autorský zoznam boli overené v PubMed a Crossref. Bezpečnostné tvrdenia boli porovnané s dvoma novšími metaanalýzami; praktická interpretácia eGFR vychádza z KDIGO 2024. Potenciálne prínosy pri CKD sú v texte zámerne oddelené od preukázaných klinických účinkov.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_kreatin-ochorenia-obliciek-bezpecnost-benefit_article',
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
