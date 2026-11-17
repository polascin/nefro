<?php
// Nový odborný článok. Avíza sa podľa pokynu používateľa nezaraďujú.
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
    'title'        => 'Kreatinín a cystatín C pri akútnom koronárnom syndróme: čo znamená nesúlad eGFR',                    // ← VYPLNIŤ: napr. 'Hyperurikémia a CKD: nové odporúčania'
    'slug'         => 'egfr-kreatinin-cystatin-c-akutny-koronarny-syndrom',                    // ← VYPLNIŤ: napr. 'hyperurikemia-ckd-nove-odporucania'
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Nižšia eGFR podľa cystatínu C než podľa kreatinínu súvisí po akútnom koronárnom syndróme s horšou prognózou. Čo ukazuje nová kohorta a kde sú hranice klinickej interpretácie?',                    // ← VYPLNIŤ: 1–2 vety, čistý text
    'content'      => <<<'HTML'
<figure><a href="img/egfr-kreatinin-cystatin-c-akutny-koronarny-syndrom.webp" target="_blank" rel="noopener noreferrer"><img src="img/egfr-kreatinin-cystatin-c-akutny-koronarny-syndrom.webp" alt="Poloschematická ilustrácia srdca a obličiek s dvoma svetelnými líniami symbolizujúcimi rozdielne odhady filtrácie." width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustrácia vytvorená pomocou umelej inteligencie. Svetelné línie symbolizujú rozdielne odhady glomerulovej filtrácie, neznázorňujú cievne spojenia ani nález konkrétneho pacienta.</figcaption></figure>
<p><strong>Nižší odhad glomerulovej filtrácie podľa cystatínu C než podľa kreatinínu môže u pacienta s akútnym koronárnym syndrómom upozorniť na nepriaznivú dlhodobú prognózu aj pri zdanlivo zachovanej funkcii obličiek podľa kreatinínu.</strong> Retrospektívna štúdia zo Santanderu túto súvislosť doložila pri celkovej úmrtnosti a poklese funkcie obličiek. Výsledky pre závažné kardiovaskulárne príhody si vyžadujú opatrnejšiu interpretáciu. Rozdiel medzi odhadmi je prognostická informácia, sám osebe však neurčuje skutočnú filtráciu ani liečbu. <a href="#ref-1">[1]</a></p>
<h2>Čo vlastne porovnávame</h2>
<p>Odhad glomerulovej filtrácie podľa kreatinínu označujeme ako eGFRcr, podľa cystatínu C ako eGFRcys a z kombinácie oboch markerov ako eGFRcr-cys. Posledný z nich je samostatný odhad vypočítaný príslušnou rovnicou. Nemožno ho zamieňať s rozdielom eGFRcys − eGFRcr ani automaticky nahradiť aritmetickým priemerom dvoch výsledkov. Všetky hodnoty uvádzané v tomto článku sú indexované na telesný povrch 1,73 m². <a href="#ref-2">[2]</a></p>
<p>Záporný rozdiel znamená, že eGFRcys je nižšia než eGFRcr. Jeho nárast o 10 ml/min/1,73 m² preto opisuje posun smerom k vyššej eGFRcys voči eGFRcr. Neznamená zlepšenie filtrácie o túto hodnotu v čase ani odpoveď na liečbu. Ide o porovnanie pacientov podľa vstupného laboratórneho nálezu. <a href="#ref-1">[1]</a></p>
<h2>Štúdia pri akútnom koronárnom syndróme</h2>
<p>Autori zaradili 808 pacientov prijatých na kardiologickú jednotku intenzívnej starostlivosti Hospital Universitario Marqués de Valdecilla v Santanderi od 1. januára 2012 do 31. decembra 2015. Podmienkou bola dostupnosť kreatinínu aj cystatínu C pri prijatí. Rozdiel medzi odhadmi posudzovali ako spojitú premennú, ako ich pomer aj pomocou kategórií s hranicou 15 ml/min/1,73 m². Nesúlad bol prítomný u 44,2 % pacientov. Tento podiel sa vzťahuje na nesúlad ako celok, nie automaticky na všetkých pacientov s nižšou eGFRcys. <a href="#ref-1">[1]</a></p>
<p>Medián sledovania bol 8,4 roka. Coxove modely zohľadňovali kardiovaskulárne rizikové faktory a kombinovanú eGFRcr-cys. Pri každom zvýšení rozdielu eGFRcys − eGFRcr o 10 ml/min/1,73 m² autori uviedli tieto pomery hazardov (HR) s 95 % intervalmi spoľahlivosti (IS): <a href="#ref-1">[1]</a></p>
<div class="table-responsive" role="region" aria-label="Výsledky upravených modelov" tabindex="0"><table><thead><tr><th scope="col">Sledovaný výsledok</th><th scope="col">HR</th><th scope="col">95 % IS</th></tr></thead><tbody><tr><th scope="row">Úmrtie z akejkoľvek príčiny</th><td>0,88</td><td>0,80 až 0,96</td></tr><tr><th scope="row">Pokles funkcie obličiek</th><td>0,80</td><td>0,71 až 0,91</td></tr><tr><th scope="row">Závažné nežiaduce kardiovaskulárne príhody (MACE)</th><td>0,91</td><td>0,83 až 1,00</td></tr></tbody></table></div>
<p>Pri úmrtnosti a poklese funkcie obličiek intervaly spoľahlivosti nezahŕňajú hodnotu 1. Pri MACE dosahuje horná hranica po zaokrúhlení hodnotu 1,00 a samotný abstrakt hovorí o trende. Z týchto údajov nemožno odvodiť absolútne zníženie rizika ani počet pacientov, ktorých by bolo potrebné liečiť. Štúdia nehodnotila liečebný zásah. <a href="#ref-1">[1]</a></p>
<h2>Suplement spresňuje hranice záveru</h2>
<p>V analýze pacientov s eGFRcr &gt; 60 ml/min/1,73 m² bol nárast rozdielu o 10 ml/min/1,73 m² spojený s nižším hazardom úmrtia (HR 0,85; 95 % IS 0,76 až 0,95) a poklesu funkcie obličiek (HR 0,69; 95 % IS 0,60 až 0,80). Pri MACE však výsledok nebol štatisticky významný: HR 0,92; 95 % IS 0,83 až 1,02; p = 0,104. V tejto podskupine preto nemožno tvrdiť, že sa nezávislá súvislosť presvedčivo potvrdila pri všetkých troch výsledkoch. <a href="#ref-1">[1, tabuľka S5]</a></p>
<p>Po vylúčení pacientov s akútnym poškodením obličiek pri prijatí pretrvala súvislosť rozdielu s úmrtnosťou, MACE aj poklesom funkcie obličiek. To znižuje pravdepodobnosť, že celý nález vysvetľuje iba vstupné akútne poškodenie, ale neodstraňuje ostatné obmedzenia observačného dizajnu. Osobitná analýza progresie do zlyhania obličiek poskytla pre rozdiel odhadov po úprave HR 0,77 (95 % IS 0,59 až 1,02; p = 0,068). Pokles funkcie obličiek teda nemožno v záveroch zamieňať s preukázanou predikciou zlyhania obličiek. <a href="#ref-1">[1, tabuľky S2 a S4]</a></p>
<h2>Prognostický marker nie je automaticky presnejšie meranie</h2>
<p>Rozdiel medzi odhadmi môže vzniknúť aj pôsobením faktorov nezávislých od filtrácie. Kreatinín ovplyvňuje svalová hmota, príjem potravy a tubulárna sekrécia. Ani cystatín C nie je od týchto vplyvov úplne oslobodený: význam môžu mať poruchy funkcie štítnej žľazy a vyššie dávky glukokortikoidov. Pri závažnom zápale, katabolizme alebo veľmi nízkej svalovej hmote môže byť nepresný aj kombinovaný odhad. U konkrétneho pacienta preto nemožno rozdiel automaticky pripísať jedinej príčine. <a href="#ref-2">[2]</a> <a href="#ref-4">[4]</a></p>
<p>Metaanalýza konzorcia CKD-PC zahŕňala 821 327 účastníkov z 23 ambulantných kohort a 39 639 pacientov z dvoch nemocničných kohort. Výrazný záporný rozdiel definovala relatívne: eGFRcys bola aspoň o 30 % nižšia než eGFRcr. V ambulantných kohortách sa spájal s vyššou úmrtnosťou a výskytom kardiovaskulárnych príhod. Táto definícia sa líši od absolútnej hranice 15 ml/min/1,73 m² v štúdii pri akútnom koronárnom syndróme, preto podiely nesúladu nemožno priamo porovnávať. Pri hodnotení obličkových výsledkov navyše záležalo na spôsobe štatistickej úpravy: po zohľadnení eGFRcr-cys sa smer asociácie so zlyhaním obličiek vyžadujúcim náhradu funkcie obličiek obrátil. Prognostický význam rozdielu teda nie je pre všetky výsledky a modely rovnaký. <a href="#ref-3">[3]</a></p>
<p>Presnosť odhadu riešila iná štúdia s 15 485 účastníkmi, u ktorých bola dostupná aj meraná glomerulová filtrácia. Ukázala, že počet nesúhlasných výsledkov aj presnosť kombinácie markerov závisia od použitých rovníc. Výsledky s rovnicami CKD-EPI, EKFC a r-LMR neboli zameniteľné. Aj táto práca oddeľuje dve otázky: ako dobre odhad vystihuje meranú filtráciu a ako dobre predpovedá budúcu príhodu. <a href="#ref-4">[4]</a></p>
<h2>Ako nález využiť v klinickej praxi</h2>
<p>KDIGO 2024 odporúča kombinovanú eGFRcr-cys v situáciách, keď je odhad podľa kreatinínu menej presný a hodnota filtrácie ovplyvňuje klinické rozhodovanie. Praktický bod 1.2.2.7 upozorňuje, že význam má smer aj veľkosť rozdielu medzi eGFRcr a eGFRcys. Pri potrebe presnejšieho posúdenia, ktorú odhady nedokážu uspokojiť, prichádza do úvahy meranie GFR pomocou exogénneho filtračného markera. <a href="#ref-2">[2]</a></p>
<p>Pri akútnom koronárnom syndróme treba výsledok najskôr zasadiť do dynamiky akútneho ochorenia. Pri neustálených koncentráciách markerov nemožno eGFR interpretovať rovnako ako v stabilnom stave. Klinicky odôvodnené je zhodnotiť vývoj kreatinínu, možné akútne poškodenie obličiek, svalovú hmotu, lieky a ďalšie príčiny rozdielu; po stabilizácii podľa potreby zopakovať vyšetrenie a doplniť albuminúriu. Jednorazový nález počas hospitalizácie sám osebe nedokazuje chronickú chorobu obličiek. <a href="#ref-2">[2]</a></p>
<p>Nižšia eGFRcys môže byť dôvodom na pozornejšie posúdenie pacienta, nie samostatnou indikáciou na zmenu antitrombotickej liečby, revaskularizačnej stratégie či nasadenie konkrétneho nefroprotektívneho lieku. Rovnako neoprávňuje mechanicky použiť nižší z dvoch odhadov na každé dávkovacie rozhodnutie. Prínos liečebnej stratégie riadenej samotným nesúladom táto kohortová štúdia netestovala. <a href="#ref-1">[1]</a> <a href="#ref-2">[2]</a></p>
<h2>Čo zostáva neisté</h2>
<p>Ide o retrospektívny súbor z jedného centra, podmienený dostupnosťou oboch markerov pri prijatí. Úprava modelov neodstraňuje reziduálne skreslenie ani výber pacientov. Zaradenie prebiehalo v rokoch 2012 až 2015, čo treba zohľadniť pri prenose výsledkov do súčasnej starostlivosti. Dostupný abstrakt a suplement neumožňujú overiť úplné definície MACE a poklesu funkcie obličiek, počty všetkých udalostí, celý postup riešenia chýbajúcich údajov ani prírastok predikčnej výkonnosti oproti zavedeným skóre. Preto článok tieto údaje nedopĺňa odhadom a štúdiu neprezentuje ako validáciu nového klinického skóre. <a href="#ref-1">[1]</a></p>
<hr><p><em>Text je určený zdravotníckym pracovníkom. Predstavuje odborné spracovanie dostupných dôkazov a nenahrádza individuálne klinické rozhodovanie.</em></p>
<p><small><em>Rozsah overenia: pri hlavnej štúdii bol dostupný úplný abstrakt, bibliografický záznam a suplement s tabuľkami S1 až S7, nie plný hlavný text. Doplňujúca interpretácia vychádza z odporúčaní KDIGO a uvedených prác. Pri práci Delanayeho a spoluautorov bola skontrolovaná aj vydavateľská oprava, ktorá upravuje úvodnú formuláciu, nie výsledky.</em></small></p>
<h2>Literatúra</h2>
<ol>
<li id="ref-1"><small><em>Cristina García Majado, Cristina Baldeón Conde, Emilio Rodrigo Calabia, José Enrique Pasache Chong, Gema Fernández Fresnedo, Juan Carlos Ruiz, José Luis Hernández. Creatinine-Cystatin C eGFR Discordance Identifies Long-Term Cardiorenal Risk in Acute Coronary Syndrome: A Cohort Study. J Nephrol. Publikované online 13. novembra 2026; aajag276. <a href="https://doi.org/10.1093/joneph/aajag276" target="_blank" rel="noopener noreferrer">DOI: 10.1093/joneph/aajag276</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/43021553/" target="_blank" rel="noopener noreferrer">PubMed: 43021553</a>. <a href="https://academic.oup.com/joneph/advance-article/doi/10.1093/joneph/aajag276/9040906" target="_blank" rel="noopener noreferrer">Vydavateľ alebo oficiálny text</a>.</em></small></li>
<li id="ref-2"><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117-S314. <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">DOI: 10.1016/j.kint.2023.10.018</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed: 38490803</a>. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Vydavateľ alebo oficiálny text</a>.</em></small></li>
<li id="ref-3"><small><em>Michelle M Estrella, Shoshana H Ballew, Yingying Sang, Morgan E Grams, Josef Coresh, Aditya Surapaneni, Natalia Alencar de Pinho, Johan Ärnlöv, Hermann Brenner, Juan-Jesus Carrero, Teresa K Chen, Debbie L Cohen, Mary Cushman, Ron T Gansevoort, Shih-Jen Hwang, Lesley A Inker, Joachim H Ix, Keiko Kabasawa, Tsuneo Konta, Jennifer S Lees, Kevan R Polkinghorne, Michael G Shlipak, Robin W M Vernooij, David C Wheeler, Ashok Kumar Yadav, Andrew S Levey, Kai-Uwe Eckardt, Chronic Kidney Disease Prognosis Consortium Investigators and Collaborators. Discordance in Creatinine- and Cystatin C-Based eGFR and Clinical Outcomes: A Meta-Analysis. JAMA. 2025;334(21):1915-1926. <a href="https://doi.org/10.1001/jama.2025.17578" target="_blank" rel="noopener noreferrer">DOI: 10.1001/jama.2025.17578</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/41202182/" target="_blank" rel="noopener noreferrer">PubMed: 41202182</a>. <a href="https://jamanetwork.com/journals/jama/fullarticle/2841167" target="_blank" rel="noopener noreferrer">Vydavateľ alebo oficiálny text</a>.</em></small></li>
<li id="ref-4"><small><em>Pierre Delanaye, Martin Flamant, Emmanuelle Vidal-Petiot, Jonas Björk, Ulf Nyman, Anders Grubb, Stephan J L Bakker, Martin H de Borst, Marco van Londen, Laurence Derain-Dubourg, Andrew D Rule, Björn O Eriksen, Toralf Melsom, Per-Ola Sundin, Natalie Ebert, Elke Schaeffner, Magnus Hansson, Karin Littmann, Anders Larsson, Thomas Stehlé, Etienne Cavalier, Justine B Bukabau, Ernest K Sumaili, Eric Yayo, Christophe Mariat, Olivier Moranne, Anders Christensson, Antoine Lanot, Hans Pottel. Discordant Results Between Creatinine- and Cystatin C-based Equations for Estimating GFR. Kidney Int Rep. 2025;10(4):1248-1259. <a href="https://doi.org/10.1016/j.ekir.2025.01.030" target="_blank" rel="noopener noreferrer">DOI: 10.1016/j.ekir.2025.01.030</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/40303200/" target="_blank" rel="noopener noreferrer">PubMed: 40303200</a>. <a href="https://www.sciencedirect.com/science/article/pii/S2468024925000555" target="_blank" rel="noopener noreferrer">Vydavateľ alebo oficiálny text</a>.</em></small></li>
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
    'log_prefix' => 'add_egfr-kreatinin-cystatin-c-akutny-koronarny-syndrom_article',
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
