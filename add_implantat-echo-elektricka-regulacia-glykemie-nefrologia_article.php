<?php
/** Odborná a jazyková revízia 2026-11-10. Bez automatických avíz. */
// Ochrana - len admin alebo CLI
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
    'title'        => 'Implantát ECHO: elektrická regulácia glykémie a otázky pre nefrológiu',
    'slug'         => 'implantat-echo-elektricka-regulacia-glykemie-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Experimentálny implantát premieňa glukózu na glukonát. Výsledky u myší sú sľubné, účinnosť u ľudí a bezpečnosť pri chronickej chorobe obličiek však zostávajú nepreukázané.',
    'content'      => <<<'HTML'
<figure><a href="img/implantat-echo-elektricka-regulacia-glykemie-nefrologia.webp" target="_blank" rel="noopener noreferrer"><img src="img/implantat-echo-elektricka-regulacia-glykemie-nefrologia.webp" alt="Poloschematická ilustrácia experimentálnej elektrokatalytickej premeny glukózy a úlohy obličiek pri odstraňovaní produktu" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna: elektrokatalytická premena glukózy a renálne odstraňovanie produktu. Nejde o zobrazenie konkrétneho výrobku ani pacienta.</figcaption></figure>
<p><strong>Experimentálny implantát premieňa glukózu na glukonát, ktorý sa vylučuje obličkami. Predklinické výsledky otvárajú nový smer výskumu diabetu 2. typu spojeného s obezitou. Účinnosť u ľudí, dlhodobá bezpečnosť a použiteľnosť pri chronickej chorobe obličiek však zostávajú nepreukázané.</strong></p>

<h2>Čo priniesla nová štúdia</h2>
<p>Debasis Maity a spoluautori publikovali v časopise <em>Science</em> prácu o implantovateľnom systéme ECHO. Skratka vychádza z anglického označenia <em>electrocatalytic closed-loop health optimization</em>. Zariadenie využíva elektricky riadenú oxidáciu glukózy na glukonát. Katalyzátor tvoria zlaté nanoklastre s platinovými časticami uložené v grafitovej plsti. Samotná katalytická premena nevyžaduje živé bunky ani enzýmy. [1]</p>
<p>U myší s experimentálnym diabetom 2. typu autori pri aktivácii napätím 0,75 V a prúdom 10 mA zaznamenali obnovenie glukózovej homeostázy v priebehu jednej hodiny. Počas šiestich týždňov liečby pozorovali pokles telesnej hmotnosti a triacylglycerolov, zvýšenie voľných mastných kyselín a ketolátok a posun k využívaniu tukov. V sledovaných podmienkach nezistili hypoglykémiu ani uvedené nežiaduce fyziologické či zápalové účinky ani zmeny správania. Prepojenie s komerčným systémom kontinuálneho monitorovania glukózy umožnilo automatické riadenie so spätnou väzbou. [1]</p>
<p>Tieto výsledky predstavujú dôkaz uskutočniteľnosti v zvieracom modeli. Neurčujú očakávaný pokles glykovaného hemoglobínu (HbA1c) u človeka, rozsah dlhodobého chudnutia ani vplyv na diabetické komplikácie.</p>

<h2>Premena glukózy nie je to isté ako jej využitie v bunke</h2>
<p>Podstatou prístupu je chemická premena časti dostupnej glukózy. Glukonát je anión kyseliny glukónovej, nie glukóza. Je preto potrebné rozlišovať odstránenie glukózy z jej bežnej metabolickej dráhy, ďalší osud vzniknutého produktu a jeho definitívne vylúčenie z organizmu. [1]</p>
<p>Samotný pokles koncentrácie glukózy nepreukazuje, že sa upravila inzulínová rezistencia, obnovila funkcia beta-buniek alebo odstránila príčina diabetu. Rovnako by bolo predčasné sľubovať energetický úbytok zodpovedajúci všetkej premenenej glukóze bez podrobnej bilancie jej produktov a metabolizmu.</p>
<p>Výraz „liečba bez liekov“ v názve pôvodnej práce vystihuje experimentálny spôsob regulácie glykémie. Nemožno ho chápať ako odporúčanie vysadiť antidiabetiká alebo ako dôkaz, že zariadenie nahradí komplexnú liečbu diabetu. [1, 2]</p>

<h2>Obličky sú súčasťou mechanizmu, nie iba orgánom sledovaným pre bezpečnosť</h2>
<p>Pre nefrológiu je rozhodujúce, že deklarovaný mechanizmus počíta s renálnym odstraňovaním glukonátu. Zníženie glykémie a dostatočné vylučovanie vzniknutého produktu sú dve odlišné otázky. Pri vývoji zariadenia pre pacientov s chronickou chorobou obličiek (CKD) bude potrebné skúmať obe. [1]</p>
<p><strong>Z dostupných výsledkov nemožno určiť hranicu odhadovanej glomerulovej filtrácie (eGFR), pri ktorej by bolo zariadenie bezpečné a účinné.</strong> Nemožno ani predpokladať jeho vhodnosť pre pacientov liečených dialýzou. Nasledujúce otázky predstavujú klinické a mechanistické požiadavky na ďalší výskum, nie preukázané komplikácie implantátu:</p>
<ul>
<li><strong>Osud glukonátu pri CKD:</strong> ako sa mení jeho koncentrácia, distribúcia a vylučovanie pri jednotlivých stupňoch poruchy funkcie obličiek?</li>
<li><strong>Bilancia tekutín a rozpustených látok:</strong> aký účinok má dlhodobá tvorba a vylučovanie produktu na diurézu, hydratáciu a elektrolytovú rovnováhu?</li>
<li><strong>Acidobázická rovnováha a ionizovaný vápnik:</strong> zostávajú stabilné aj pri dlhodobej aktivácii a pri obmedzenom renálnom vylučovaní?</li>
<li><strong>Akútne zhoršenie funkcie obličiek:</strong> má riadenie zariadenia zohľadňovať aj schopnosť odstraňovať produkt, nielen aktuálnu koncentráciu glukózy?</li>
<li><strong>Dialýza:</strong> aký je osud glukonátu medzi procedúrami a počas nich a ako sa mení celková metabolická bilancia?</li>
</ul>
<p>Opatrnosť má aj podklad v klinickej literatúre z iného prostredia. V malej randomizovanej štúdii u 28 kriticky chorých pacientov s popáleninami sa po podávaní infúzneho roztoku Plasmalyte zistila akumulácia glukonátu a nižšia koncentrácia ionizovaného vápnika než pri Ringerovom laktáte. Nešlo o implantát ECHO ani o štúdiu určujúcu jeho bezpečnosť pri CKD. Odlišné zloženie roztokov a klinická situácia neumožňujú pripísať všetky rozdiely samotnému glukonátu. Práca však upozorňuje, že jeho osud a sprievodné biochemické zmeny nemožno pri klinickom vývoji obísť. [3]</p>

<h2>Vzostup ketolátok vyžaduje samostatné hodnotenie</h2>
<p>V experimentálnej práci sa zvýšila koncentrácia ketolátok. [1] Tento nález sám osebe neznamená ketoacidózu. Nemožno ho však použiť ani ako dôkaz bezpečnosti pri nedostatku inzulínu. V klinických skúšaniach by bolo potrebné vyhodnotiť ketolátky spolu s acidobázickým stavom, príjmom potravy, interkurentnými ochoreniami a súbežnou liečbou.</p>
<p>Úspech v modeli diabetu 2. typu navyše neposkytuje dôkaz použiteľnosti pri diabete 1. typu. Pokles glykémie nie je dostatočným podkladom na záver, že zariadenie dokáže nahradiť inzulín.</p>

<h2>Automatické riadenie nezaručuje bezpečnosť vo všetkých situáciách</h2>
<p>Systém so spätnou väzbou má prispôsobovať aktivitu zariadenia nameranej koncentrácii glukózy. Neprítomnosť zachytenej hypoglykémie v krátkodobom zvieracom experimente však nevylučuje jej riziko u človeka. Budúce skúšania musia preveriť správanie pri chybnej hodnote snímača, prerušení komunikácie, výpadku napájania a rýchlej zmene glykémie. [1]</p>
<p>Rovnako treba overiť dlhodobú funkčnosť katalyzátora v tkanive, lokálnu reakciu na implantát, prípadné uvoľňovanie jeho zložiek a spôsob bezpečného vyradenia alebo odstránenia zariadenia. Ide o otvorené otázky klinického vývoja. Šesťtýždňové sledovanie ich nemôže definitívne uzavrieť.</p>

<h2>Zníženie glykémie ešte nepreukazuje ochranu obličiek</h2>
<p>Pri diabete a CKD sa liečba hodnotí aj podľa schopnosti spomaľovať progresiu choroby obličiek a znižovať kardiovaskulárne riziko. Konsenzus ADA a KDIGO zdôrazňuje komplexnú starostlivosť a používanie liečby s preukázaným prínosom pre tieto výsledky. [2]</p>
<p>Rozdiel medzi metabolickým účinkom a klinicky doloženým prínosom ukazuje štúdia FLOW. U 3 533 pacientov s diabetom 2. typu a CKD znížil semaglutid oproti placebu hazard výskytu primárneho kombinovaného ukazovateľa o 24 % počas mediánu sledovania 3,4 roka. Ukazovateľ zahŕňal zlyhanie obličiek, pretrvávajúci pokles eGFR najmenej o 50 % alebo úmrtie z renálnych či kardiovaskulárnych príčin; pomer hazardov (HR) bol 0,76 (95 % interval spoľahlivosti 0,66 až 0,88). [4]</p>
<p>Tento príklad nie je priamym porovnaním so zariadením ECHO. Ukazuje však, aký druh dôkazov je potrebný pred tvrdením o ochrane obličiek. Pri implantáte zatiaľ takéto klinické výsledky chýbajú. Samotný pokles glykémie alebo telesnej hmotnosti ich nenahrádza.</p>

<h2>Limity dostupných dôkazov</h2>
<p>Základné výsledky práce ECHO sú overené podľa publikovaného abstraktu. Plný text ani prílohy neboli dostupné, preto tu nehodnotíme počty zvierat, randomizáciu, zaslepenie, úplnosť kontrolných skupín ani podrobnosti renálneho a toxikologického vyšetrenia. Šesť týždňov experimentálnej liečby nepostačuje na záver o dlhodobej bezpečnosti. Uvedené otázky pri CKD sú odbornou interpretáciou mechanizmu, nie výsledkom skúšania u pacientov s CKD.</p>

<h2>Čo si z výsledkov odniesť do praxe</h2>
<p>ECHO prináša nový spôsob experimentálnej regulácie glukózy pomocou riadenej chemickej reakcie. Jeho ďalší vývoj bude závisieť od toho, či sa podarí preukázať udržateľný účinok a prijateľnú bezpečnosť pri dlhodobom používaní u človeka.</p>
<p><strong>Pre nefrológa je kľúčová otázka, ako sa bude odstraňovať produkt premeny pri zníženej funkcii obličiek. Kým nebudú dostupné príslušné údaje, nemožno implantát považovať za liečbu CKD ani za náhradu postupov s preukázaným renálnym a kardiovaskulárnym prínosom.</strong></p>

<hr><p><em>Text je určený zdravotníckym pracovníkom. Experimentálne zariadenie nepredstavuje odporúčanie na zmenu liečby konkrétneho pacienta.</em></p>
<h2>Literatúra a zdroje</h2>
<p><small><em>1. Debasis Maity, Preetam Guha Ray, Peter Buchmann, Ghislaine Charpin-El Hamri, Martin Fussenegger. Wireless electrocatalytic closed-loop system for drug-free management of diabesity. Science. 2026;394(6822):eady8560. Publikované 22. októbra 2026. DOI: 10.1126/science.ady8560.</em><br><a href="https://pubmed.ncbi.nlm.nih.gov/42912137/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1126/science.ady8560" target="_blank" rel="noopener noreferrer">DOI a stránka vydavateľa</a></small></p>
<p><small><em>2. Ian H. de Boer, Kamlesh Khunti, Tami Sadusky, Katherine R. Tuttle, Joshua J. Neumiller, Connie M. Rhee, Sylvia E. Rosas, Peter Rossing, George Bakris. Diabetes Management in Chronic Kidney Disease: A Consensus Report by the American Diabetes Association (ADA) and Kidney Disease: Improving Global Outcomes (KDIGO). Diabetes Care. 2022;45(12):3075-3090. DOI: 10.2337/dci22-0027.</em><br><a href="https://pubmed.ncbi.nlm.nih.gov/36189689/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC9870667/" target="_blank" rel="noopener noreferrer">Plný text</a></small></p>
<p><small><em>3. Maïté Chaussard, François Dépret, Oriane Saint-Aubin, Mourad Benyamina, Maxime Coutrot, Marion Jully, Haikel Oueslati, Alexandre Fratani, Alexandru Cupaciu, Alicia Poniard, Karim Asehnoune, Solohaja-Faniaha Dimby, Alexandre Mebazaa, Pascal Houze, Matthieu Legrand. Physiological response to fluid resuscitation with Ringer lactate versus Plasmalyte in critically ill burn patients. Journal of Applied Physiology. 2020;128(3):709-714. DOI: 10.1152/japplphysiol.00859.2019.</em><br><a href="https://pubmed.ncbi.nlm.nih.gov/32027547/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1152/japplphysiol.00859.2019" target="_blank" rel="noopener noreferrer">DOI</a></small></p>
<p><small><em>4. Vlado Perkovic, Katherine R. Tuttle, Peter Rossing, Kenneth W. Mahaffey, Johannes F. E. Mann, George Bakris, Florian M. M. Baeres, Thomas Idorn, Heidrun Bosch-Traberg, Nanna Leonora Lausvig, Richard Pratley; FLOW Trial Committees and Investigators. Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes. New England Journal of Medicine. 2024;391(2):109-121. DOI: 10.1056/NEJMoa2403347. </em><br><a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">DOI</a></small></p>
<p><small><em>Inštitucionálny sprievodný zdroj: Peter Rüegg. Elektronisches Implantat gegen Diabetes: Wie ein Mini-Katalysator Zucker im Blut abbaut. ETH Zürich, 22. októbra 2026.</em><br><a href="https://ethz.ch/de/news-und-veranstaltungen/eth-news/news/2026/10/ein-elektronisches-implantat-gegen-diabetes.html" target="_blank" rel="noopener noreferrer">ETH Zürich</a></small></p>
<p><small><em>Stav dôkazov k 10. novembru 2026: bibliografia a abstrakty štyroch citovaných prác, časť konsenzu ADA/KDIGO s hlavnými stanoviskami a správa ETH Zürich. KDIGO na oficiálnej stránke naďalej uvádza vydanie z roku 2022 ako platné publikované diabetologické usmernenie; pripravovaná verzia 2026 ešte nie je konečným odporúčaním. Nefrologické otázky sú vlastnou odbornou interpretáciou.</em> <a href="https://kdigo.org/guidelines/diabetes-ckd/" target="_blank" rel="noopener noreferrer">Aktuálny stav KDIGO</a></small></p>
<h3>Súvisiaci článok</h3><p><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">CKD pri diabete: skríning a vrstvená kardiorenálna liečba</a></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// Avíza sú na výslovný pokyn používateľa vypnuté.
// Pri dávke N článkov to znamená N × počet odberateľov e-mailov naraz
// (2026-09-09: 12 článkov = 144 e-mailov). Preto je predvolená hodnota `false`.
// Na `true` prepni vedome , pri jednom článku, ktorý má ísť do newslettera.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_implantat-echo-elektricka-regulacia-glykemie-nefrologia_article',
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
