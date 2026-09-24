<?php

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
    'title' => 'Alogliptín a obličkové výsledky: čo ukazuje porovnanie inhibítorov DPP-4',
    'slug' => 'alogliptin-dpp4-inhibitory-oblickove-vysledky-diabetes',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt' => 'Alogliptín sa v observačnej štúdii spájal s priaznivejšími obličkovými výsledkami. Čo ukázali doplnkové analýzy a prečo nález zatiaľ nepreukazuje nefroprotekciu?',
    'content'      => <<<'HTML'
<p>Alogliptín sa v americkej observačnej štúdii spájal s nižším výskytom novozaznamenaného stredne závažného až závažného ochorenia obličiek než linagliptín, saxagliptín a sitagliptín. Štúdia však nepreukazuje priamy nefroprotektívny účinok ani nadradenosť alogliptínu v prevencii dialýzy. Chýbajúce laboratórne údaje, rozdiely medzi skupinami a menej presvedčivé doplnkové analýzy vyžadujú opatrnú interpretáciu. [1, 2]</p>

<h2>Čo autori porovnávali</h2>
<p>Sklepinski a spoluautori publikovali v roku 2026 emuláciu cieľovej klinickej štúdie (<em>target trial emulation</em>) s využitím údajov amerických zdravotných poisťovní. Porovnávali začatie liečby štyrmi inhibítormi dipeptidylpeptidázy 4 (DPP-4) v rokoch 2014 až 2021 u dospelých od 21 rokov s diabetom 2. typu a stredným kardiovaskulárnym rizikom. Na začiatku nesmeli mať v administratívnych údajoch zaznamenané CKD štádia 3 až 5, zlyhanie obličiek ani liečbu nahrádzajúcu funkciu obličiek. [1, 2]</p>
<p>Podľa prílohy bolo stredné riziko definované ako odhadované ročné riziko závažnej kardiovaskulárnej príhody 1 až 5 % pomocou modelu ACME založeného na administratívnych údajoch. Nejde o kategóriu určenú pomocou SCORE2-Diabetes. Vylúčení boli aj pacienti s predchádzajúcim používaním inzulínu alebo inhibítora DPP-4 vo vstupnom 12-mesačnom období. Zaradenie vyžadovalo opakovaný výdaj toho istého lieku, preto výsledky nemožno bez výhrad preniesť na všetkých pacientov po prvom predpise. [2]</p>
<p><strong>Neprítomnosť diagnostického kódu CKD nie je dôkazom normálnej funkcie obličiek.</strong> Bez hodnôt odhadovanej glomerulovej filtrácie (eGFR) a pomeru albumínu ku kreatinínu v moči (UACR) nemožno spoľahlivo vylúčiť nerozpoznané CKD. Kategória G3 navyše znamená už stredne zníženú filtráciu; označenie populácie iba ako „bez pokročilého CKD“ je nepresné. Ani zachovaná eGFR sama osebe nevylučuje CKD pri pretrvávajúcej albuminúrii alebo inom poškodení obličiek. [1, 2, 5]</p>

<h2>Skutočné počty pacientov a štatistické váženie</h2>
<p>V pôvodnej kohorte pred vážením bolo 2 491 používateľov alogliptínu, 37 438 linagliptínu, 17 071 saxagliptínu a 118 468 sitagliptínu, spolu 175 468 osôb. Abstrakt uvádza vážené počty 3 026, 38 213, 14 934 a 115 091. Tieto dve sady údajov nemožno zamieňať. Váženie vytvára analytickú pseudopopuláciu; nepridáva nových nezávislých pacientov. [1, 2]</p>
<p>Autori odhadli pravdepodobnosť výberu jednotlivých liekov pomocou súboru predikčných algoritmov SuperLearner a použili váženie inverznou pravdepodobnosťou liečby v Coxových modeloch. Takýto postup môže zlepšiť porovnateľnosť skupín v meraných charakteristikách, ale nenahrádza randomizáciu a nevyrovná rozdiely v premenných, ktoré databáza neobsahuje. Pred vážením sa skupiny výrazne líšili: priemerný vek bol napríklad približne 60 rokov pri alogliptíne a 68 rokov pri sitagliptíne. [1, 2]</p>

<h2>Primárny ukazovateľ a hlavné výsledky</h2>
<p>Abstrakt definuje primárny kombinovaný ukazovateľ ako novozaznamenané CKD štádia 3 až 5, zlyhanie obličiek alebo začatie liečby nahrádzajúcej funkciu obličiek. Výsledok je založený na administratívnych kódoch, nie na potvrdenom poklese eGFR alebo zmene albuminúrie. Nasledujúce percentá predstavujú publikované odhady výskytu kombinovaného ukazovateľa. [1]</p>
<div class="table-responsive pdf-keep-together" role="region" aria-label="Odhad výskytu primárneho ukazovateľa podľa lieku" tabindex="0">
<table>
<thead><tr><th scope="col">Liečivo</th><th scope="col">Po 1 roku</th><th scope="col">Po 3 rokoch</th></tr></thead>
<tbody>
<tr><th scope="row">Alogliptín</th><td>1,4 %</td><td>3,2 %</td></tr>
<tr><th scope="row">Linagliptín</th><td>2,7 %</td><td>6,2 %</td></tr>
<tr><th scope="row">Saxagliptín</th><td>2,2 %</td><td>5,0 %</td></tr>
<tr><th scope="row">Sitagliptín</th><td>2,4 %</td><td>5,4 %</td></tr>
</tbody>
</table>
</div>
<p>Pre alogliptín oproti linagliptínu bol pomer rizík (HR) 0,50 (95 % interval spoľahlivosti [IS] 0,37 až 0,69), oproti saxagliptínu 0,63 (95 % IS 0,45 až 0,86) a oproti sitagliptínu 0,58 (95 % IS 0,42 až 0,79). HR opisuje pomer okamžitých rizík udalosti v čase; nie je totožný s pomerom trojročných kumulatívnych rizík. [1]</p>
<p>Z uvedených zaokrúhlených percent vychádzajú po troch rokoch absolútne rozdiely v prospech alogliptínu 3,0 percentuálneho bodu oproti linagliptínu, 1,8 oproti saxagliptínu a 2,2 oproti sitagliptínu. Ide o vlastný jednoduchý prepočet publikovaných odhadov, nie o dodatočný výsledok analýzy. Rozdiely netreba označovať automaticky za klinicky zanedbateľné, ale <strong>nemožno ich vydávať za preukázaný liečebný účinok ani z nich odvodiť spoľahlivé NNT</strong>, teda počet pacientov potrebných liečiť na zabránenie jednej udalosti.</p>

<h2>Čo ukázali doplnkové analýzy</h2>
<p>Primárna analýza sledovala stratégiu začatia liečby v modifikovanom prístupe podľa pôvodne priradenej liečby. Príloha uvádza aj analýzu, v ktorej sa sledovanie ukončilo pri vysadení skúmaného lieku. V nej bol HR pre alogliptín oproti sitagliptínu 0,75 (95 % IS 0,44 až 1,24) a oproti saxagliptínu 0,78 (95 % IS 0,46 až 1,33). Oba intervaly zahŕňajú hodnotu 1. Porovnanie s linagliptínom zostalo štatisticky významné: HR 0,55 (95 % IS 0,33 až 0,92). [2, tabuľka 11]</p>
<p>Pri ukončení sledovania aj po pridaní ďalšej liekovej triedy už intervaly spoľahlivosti pri všetkých troch porovnaniach alogliptínu zahŕňali hodnotu 1. V analýze obdobia po druhom roku boli odhady HR alogliptínu oproti ostatným liekom blízke 1, tiež bez štatisticky presvedčivého rozdielu. Tieto výsledky nevyvracajú automaticky hlavnú analýzu: mení sa hodnotená stratégia, dĺžka sledovania aj presnosť odhadu a môže vzniknúť skreslenie pri ukončovaní sledovania. Nepodporujú však jednoznačný záver o stabilnej ochrane počas užívania alogliptínu. [2, tabuľky 9 a 12]</p>
<p><small><em>Metodická výhrada k zdroju: poznámky pod niektorými doplnkovými tabuľkami používajú výraz „acute kidney failure“, zatiaľ čo abstrakt uvádza „kidney failure“ a tabuľka 4 rozpisuje CKD, zlyhanie obličiek a náhradu ich funkcie. Ide o vnútorný nesúlad publikovaných materiálov. Bez jeho objasnenia nemožno tvrdiť, že štúdia preukázala prevenciu akútneho poškodenia obličiek. Opis hlavného ukazovateľa v tomto článku vychádza z abstraktu a kódovej tabuľky. [1, 2]</em></small></p>

<h2>Prečo asociácia ešte neznamená nefroprotekciu</h2>
<ul>
<li><strong>Chýbajú laboratórne údaje:</strong> nebolo možné priamo vyrovnať skupiny podľa HbA1c, eGFR či albuminúrie ani sledovať ich dynamiku. Nový diagnostický kód môže odrážať aj neskoršie rozpoznanie už existujúceho ochorenia. [1, 2]</li>
<li><strong>Výber lieku môže súvisieť s funkciou obličiek:</strong> linagliptín nevyžaduje úpravu dávky pri poruche funkcie obličiek. Je preto klinicky možné, že ho lekári častejšie volili u rizikovejších pacientov, ktorých renálne riziko administratívne údaje úplne nezachytili. Ide o možný mechanizmus skreslenia, nie o dokázané vysvetlenie výsledku. [1, 7]</li>
<li><strong>Alogliptínová skupina bola podstatne menšia:</strong> veľkosť celkovej databázy nezaručuje rovnakú presnosť každého porovnania. Široké intervaly v doplnkových analýzach vyjadrujú neistotu. [2]</li>
<li><strong>Kombinovaný ukazovateľ sa nesmie zamieňať s jeho najzávažnejšou zložkou:</strong> HR pre celý ukazovateľ neznamená rovnaké zníženie rizika dialýzy, transplantácie alebo nezvratného zlyhania obličiek. [1, 2]</li>
</ul>

<h2>Kontext randomizovaných štúdií</h2>
<p>V štúdii CARMELINA sa u pacientov s diabetom 2. typu a vysokým kardiovaskulárnym a renálnym rizikom porovnával linagliptín s placebom. Sekundárny obličkový ukazovateľ zahŕňal úmrtie z renálnych príčin, terminálne zlyhanie obličiek alebo pretrvávajúci pokles eGFR najmenej o 40 %. Výsledok bol HR 1,04 (95 % IS 0,89 až 1,22), bez preukázaného rozdielu. Observačný nález vyššieho rizika pri linagliptíne preto nemožno automaticky interpretovať ako jeho nefrotoxicitu. Zároveň nejde o priame randomizované porovnanie linagliptínu s alogliptínom. [3]</p>
<p>EXAMINE hodnotila predovšetkým kardiovaskulárnu bezpečnosť alogliptínu po akútnom koronárnom syndróme. Preukázaná noninferiorita v kardiovaskulárnom ukazovateli nie je dôkazom renálnej ochrany; výskyt začatia dialýzy bol v abstrakte opísaný ako podobný pri alogliptíne a placebe. Populácia sa navyše líšila od novšej observačnej štúdie. [4]</p>

<h2>Dôsledky pre výber liečby a bezpečnosť</h2>
<p><strong>Samotná táto štúdia nie je dostatočným dôvodom na zmenu stabilnej liečby alebo na rutinné uprednostnenie alogliptínu pre ochranu obličiek.</strong> Inhibítor DPP-4 sa vyberá predovšetkým na kontrolu glykémie s ohľadom na funkciu obličiek, pridružené ochorenia, bezpečnosť, toleranciu a dostupnosť. Nedostupnosť či kontraindikácia inej liekovej triedy nemení observačnú asociáciu na dokázaný nefroprotektívny účinok.</p>
<p>U pacientov s diabetom 2. typu a CKD odporúča KDIGO 2024 inhibítor SGLT2 pri eGFR ≥ 20 ml/min/1,73 m². Lieky s preukázaným orgánovým prínosom treba používať podľa ich indikácie a individuálneho rizika. Pre agonistu receptora GLP-1 semaglutid poskytla štúdia FLOW u vybranej populácie s diabetom 2. typu a CKD randomizovaný dôkaz zníženia kombinácie závažných obličkových príhod a kardiovaskulárneho úmrtia. Tento dôkaz nemožno zamieňať s porovnaním gliptínov v administratívnej databáze. [5, 8]</p>
<p>Podľa súhrnu charakteristických vlastností lieku Vipidia je obvyklá dávka alogliptínu 25 mg raz denne. Pri klírense kreatinínu (CrCl) ≥ 30 až ≤ 50 ml/min sa znižuje na 12,5 mg raz denne a pri CrCl &lt; 30 ml/min alebo terminálnom zlyhaní obličiek vyžadujúcom dialýzu na 6,25 mg raz denne. <strong>CrCl v ml/min nemožno bez posúdenia zamieňať s eGFR prepočítanou na 1,73 m².</strong> Renálna funkcia sa má zhodnotiť pred liečbou aj počas nej. Možnosť upraveného dávkovania pri CKD sama osebe nepreukazuje nefroprotekciu. [6]</p>
<p>Európska informácia o lieku upozorňuje na obmedzené skúsenosti pri srdcovom zlyhávaní NYHA III až IV a odporúča opatrnosť. FDA navyše vydala upozornenie na možné zvýšenie rizika srdcového zlyhávania pri alogliptíne a saxagliptíne, najmä u pacientov so srdcovým alebo obličkovým ochorením. Tento bezpečnostný kontext musí byť súčasťou rozhodovania, ak sa uvažuje o zmene lieku na základe neistej renálnej výhody. [6, 9]</p>

<h2>Záver</h2>
<p>Nová štúdia prináša hypotézu o rozdieloch medzi jednotlivými inhibítormi DPP-4, nie potvrdenie nefroprotektívnej indikácie alogliptínu. Hlavné výsledky sú zaujímavé, ale ich presvedčivosť oslabujú chýbajúce laboratórne údaje a menej jednoznačné doplnkové analýzy. Pre nefrológa zostáva rozhodujúce skutočné zhodnotenie eGFR a albuminúrie, bezpečný liekový predpis a uprednostnenie intervencií s preukázaným prínosom pre daného pacienta.</p>
<p><small><em>Odborné spracovanie vychádza z verejného abstraktu pôvodnej štúdie, overených bibliografických údajov a otvorenej prílohy vrátane definícií a doplnkových analýz. Plný hlavný text nebol dostupný na overenie. Záznam pôvodnej štúdie sa pri kontrole v PubMed/Europe PMC nepodarilo nájsť; jej DOI a autorstvo boli overené cez Crossref a vydavateľský záznam. Kontextové randomizované štúdie boli overené aj cez PubMed/Europe PMC. Stav overenia: 24. september 2026.</em></small></p>
<hr>
<h2>Zdroje</h2>
<ol>
<li><small><em>Stacey M. Sklepinski; Jeph Herrin; Joshua J. Neumiller; Eric C. Polley; Kavya Sindhu Swarna; Yihong Deng; Rodolfo J. Galindo; Guillermo E. Umpierrez; Joseph S. Ross; Juan P. Brito; Victor M. Montori; Mindy M. Mickelson; Rozalina G. McCoy. Comparative Effectiveness of Individual DPP-4 Inhibitors on Kidney Outcomes in Type 2 Diabetes With Moderate Cardiovascular Risk: A Target Trial Emulation. Diabetes, Obesity, and CardioMetabolic CARE. 2026;1(4):628–637. <a href="https://doi.org/10.2337/doc26-0025" target="_blank" rel="noopener noreferrer">DOI</a>.</em></small></li>
<li><small><em>Sklepinski SM a spoluautori. Doplnkové materiály k pôvodnej štúdii, najmä tabuľky 1, 4, 6, 9, 11 a 12. <a href="https://doi.org/10.2337/figshare.32573031" target="_blank" rel="noopener noreferrer">Príloha</a>.</em></small></li>
<li><small><em>Rosenstock J, Perkovic V, Johansen OE, Cooper ME, Kahn SE, Marx N, Alexander JH, Pencina M, Toto RD, Wanner C, Zinman B, Woerle HJ, Baanstra D, Pfarr E, Schnaidt S, Meinicke T, George JT, von Eynatten M, McGuire DK, CARMELINA Investigators. Effect of Linagliptin vs Placebo on Major Cardiovascular Events in Adults With Type 2 Diabetes and High Cardiovascular and Renal Risk: The CARMELINA Randomized Clinical Trial. JAMA. 2019;321(1):69-79. <a href="https://pubmed.ncbi.nlm.nih.gov/30418475/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>White WB, Cannon CP, Heller SR, Nissen SE, Bergenstal RM, Bakris GL, Perez AT, Fleck PR, Mehta CR, Kupfer S, Wilson C, Cushman WC, Zannad F, EXAMINE Investigators. Alogliptin after acute coronary syndrome in patients with type 2 diabetes. N Engl J Med. 2013;369(14):1327-1335. <a href="https://pubmed.ncbi.nlm.nih.gov/23992602/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117–S314. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Odporúčanie</a>.</em></small></li>
<li><small><em>European Medicines Agency. Vipidia: súhrn charakteristických vlastností lieku, časti 4.1, 4.2 a 4.4. <a href="https://www.ema.europa.eu/en/documents/product-information/vipidia-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">EMA</a>.</em></small></li>
<li><small><em>European Medicines Agency. Trajenta: súhrn charakteristických vlastností lieku, časť 4.2. <a href="https://www.ema.europa.eu/en/documents/product-information/trajenta-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">EMA</a>.</em></small></li>
<li><small><em>Perkovic V, Tuttle KR, Rossing P, Mahaffey KW, Mann JFE, Bakris G, Baeres FMM, Idorn T, Bosch-Traberg H, Lausvig NL, Pratley R, FLOW Trial Committees and Investigators. Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes. N Engl J Med. 2024;391(2):109-121. <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>U.S. Food and Drug Administration. Drug Safety Communication: upozornenie na riziko srdcového zlyhávania pri saxagliptíne a alogliptíne. 5. apríla 2016. <a href="https://www.fda.gov/media/96895/download" target="_blank" rel="noopener noreferrer">FDA</a>.</em></small></li>
</ol>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// POZOR: každý vložený článok zaradí samostatné avízo pre KAŽDÉHO odberateľa.
// Pri dávke N článkov to znamená N × počet odberateľov e-mailov naraz
// (2026-09-09: 12 článkov = 144 e-mailov). Preto je predvolená hodnota `false`.
// Na `true` prepni vedome — pri jednom článku, ktorý má ísť do newslettera.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_alogliptin-dpp4-inhibitory-oblickove-vysledky-diabetes_article',
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
