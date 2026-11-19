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
    'title' => 'Chronická choroba obličiek neznámej etiológie v roku 2026: čo vieme a čo stále nie',
    'slug' => 'ckdu-neznama-etiologia-2026',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt' => 'Prehľad v AJKD 2026 vysvetľuje, prečo príčina epidémií CKDu v Strednej Amerike a južnej Ázii zostáva neznáma a prečo horúčava vystupuje skôr ako faktor zhoršujúci už prítomné ochorenie.',
    'content'      => <<<'HTML'
<p>Chronická choroba obličiek neznámej etiológie (CKDu, z angl. <em>chronic kidney disease of undetermined etiology</em>) sa v epidemickej miere vyskytuje v poľnohospodárskych oblastiach Strednej Ameriky, Srí Lanky a južnej Indie. Prehľad publikovaný v roku 2026 v American Journal of Kidney Diseases zhŕňa, čo sa po dvoch desaťročiach výskumu dá povedať s istotou a kde sa poznanie zatiaľ zastavuje. Svetová zdravotnícka organizácia v roku 2025 vyzvala na riešenie týchto epidémií v rámci rezolúcie o zdraví obličiek [1].</p>
<figure><a href="img/ckdu-neznama-etiologia-2026.webp" rel="noopener noreferrer" target="_blank"><img src="img/ckdu-neznama-etiologia-2026.webp" alt="Polopriesvitná oblička nad poľom cukrovej trstiny pri západe slnka" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná scéna vytvorená s podporou umelej inteligencie, nie snímka konkrétneho pacienta ani miesta.</figcaption></figure>
<p>Hlavný záver autorov je opatrný. Novšie údaje podporujú úlohu tepelnej záťaže skôr ako dôležitého faktora, ktorý zhoršuje už prítomné ochorenie, než ako vysvetlenie samotných epidemických zhlukov. Príčina epidémií zostáva neznáma [1].</p>

<h2>Syndróm, nie jedna choroba</h2>
<p>CKDu je zastrešujúce označenie klinického syndrómu. Prvé opisy pochádzajú z 90. rokov zo Severocentrálnej provincie Srí Lanky a z pobrežia Salvádoru, kde pribúdali pacienti na dialýze bez zjavnej primárnej choroby obličiek. Diabetes, glomerulonefritída ani cievne ochorenie u väčšiny z nich neboli prítomné. Histologický obraz pokročilého ochorenia je v Strednej Amerike aj v južnej Ázii podobný: tubulointersticiálna fibróza a glomeruloskleróza bez výraznejšej aktívnej zápalovej alebo imunitne podmienenej lézie [1].</p>
<p>Regionálne definície prípadu, ktoré pripravili latinskoamerická, srílanská a indická nefrologická spoločnosť, sa líšia. Všetky však vyžadujú chronickú chorobu obličiek podľa KDIGO, zvyčajne eGFR pod 60 ml/min/1,73 m² alebo zvýšené vylučovanie bielkovín močom, a vylúčenie známych príčin. Patognomický nález, ktorý by diagnózu potvrdil, nepriniesla ani elektrónová mikroskopia vo výskumných súboroch [1].</p>
<p>Z tubulointersticiálneho fenotypu vyplýva praktický problém. V skorom štádiu chýba hematúria a albuminúria je nízka alebo žiadna, takže definícia prípadu zachytí ochorenie až pri eGFR pod 60 ml/min/1,73 m². Pre skoršie štádiá sa preto používajú regionálne názvy, napríklad mezoamerická nefropatia, uddanamská nefropatia alebo chronická intersticiálna nefritída v poľnohospodárskych komunitách. Označenie CKDu sa navyše používalo aj pre albuminurické ochorenia, monogénové choroby či ojedinelé prípady CKD bez diagnózy. Autori ho vymedzujú úzko: neznáma príčina, vysoká záťaž v geografických zhlukoch a chronický tubulointersticiálny fenotyp [1].</p>

<h2>Kde sa epidémie skutočne vyskytujú</h2>
<p>Registre dialýzy a úmrtné listy záťaž v krajinách s obmedzenými zdrojmi podhodnocujú, pretože pokročilé ochorenie má nešpecifické príznaky a dialýza je dostupná len časti chorých. Spoľahlivejšie sú populačne reprezentatívne prieskumy. Štandardizovaný projekt DEGREE porovnával prevalenciu nízkej eGFR u dospelých vo veku 18 až 60 rokov bez tradičných rizikových faktorov. Potvrdil epidemickú záťaž v pacifických oblastiach Nikaraguy a Salvádoru, v Severocentrálnej provincii Srí Lanky a v indickom štáte Ándhrapradéš [1, 2].</p>
<p>Rovnako dôležité je, kde sa vysoká záťaž nenašla. Podľa prehľadu chýbala vo viacerých horúcich vidieckych oblastiach vrátane severovýchodného Thajska [1]. V nepálskom prieskume s 1 438 účastníkmi, z ktorých 718 sa nedávno vrátilo z práce v štátoch Perzského zálivu alebo v Malajzii, malo eGFR pod 60 ml/min/1,73 m² iba 6 osôb (0,4 %) [3]. Médiá pritom predtým o tejto skupine pracovníkov písali ako o obetiach epidémie zlyhania obličiek. Doteraz opísané rizikové faktory podľa autorov rozloženie ochorenia nevysvetľujú [1].</p>

<h2>Dôsledky pre ľudí a krajiny</h2>
<p>CKDu postihuje najmä ľudí v produktívnom veku v chudobných komunitách, kde dialýza ani transplantácia často nie sú dostupné. Ak nerátame úrazy, CKD je podľa prehľadu najčastejšou príčinou úmrtí dospelých v produktívnom veku v Salvádore a Nikarague a treťou najčastejšou na Srí Lanke. Na Srí Lanke viedli obavy z úlohy agrochemikálií k ich zákazu, čo prispelo k vážnemu hospodárskemu prepadu [1].</p>

<h2>Navrhované príčiny a problém ich interpretácie</h2>
<p>Hypotézy sa delia do štyroch skupín: námahová tepelná záťaž, organické toxíny vrátane agrochemikálií, kovy a metaloidy a infekcie. Nízka pôrodná hmotnosť, genetická predispozícia, nefrotoxické lieky a kontaminovaný alkohol sa posudzujú skôr ako prispievajúce faktory [1].</p>
<p>Ústredný metodický problém spočíva v tom, že viaceré podozrivé expozície zhoršujú aj CKD známej príčiny. Dehydratácia, infekcie a nefrotoxické lieky sú v chudobných oblastiach bežné. V populácii s vysokou prevalenciou ochorenia obličiek preto možno očakávať ich asociáciu s poklesom eGFR bez ohľadu na to, čo ochorenie vyvolalo. Keďže začiatok CKDu sa takmer nedá zachytiť, je ťažké odlíšiť expozíciu, ktorá ochorenie spúšťa, od expozície, ktorá ho iba urýchľuje [1].</p>

<h2>Horúčava: súvislosť áno, vysvetlenie epidémie zatiaľ nie</h2>
<p>Najviac etiologických prác sa venuje tepelnej záťaži. V Strednej Amerike sa náhradné ukazovatele pracovnej tepelnej záťaže opakovane spájajú s poklesom eGFR aj so stanovenou CKD [1]. Opatrenia zamerané na prestávky, hydratáciu a tieň u pracovníkov na cukrovej trstine v Salvádore priniesli priaznivé zmeny. U rezačov spálenej trstiny klesla eGFR počas druhej žatvy priemerne o 6 ml/min/1,73 m² menej než počas prvej (95 % IS 2 až 9) a výskyt nového poškodenia obličiek bol o 70 % nižší. Išlo o porovnanie dvoch po sebe idúcich sezón, nie o randomizovanú štúdiu [4].</p>
<p>Proti jednoduchému kauzálnemu výkladu hovoria tri pozorovania. V postihnutých oblastiach ochorejú aj ľudia bez pracovnej tepelnej expozície, hoci menej často. Populácie vybrané práve pre vysokú pracovnú tepelnú záťaž, napríklad spomínaní nepálski migranti, epidemickú záťaž nemajú [1, 3]. A okolitá horúčava, fyziologicky slabší podnet než námahová záťaž, sa spájala s poklesom eGFR aj u pacientov s CKD známej príčiny v post hoc analýze štúdie DAPA-CKD so 4 017 účastníkmi z 21 krajín [5]. Autori prehľadu z toho vyvodzujú, že horúčava je pravdepodobne dôležitým faktorom zhoršujúcim už prítomné ochorenie, dostupné dôkazy však nestačia na záver, že vysvetľuje epidemickú záťaž [1].</p>
<p>Pri ostatných hypotézach sú dôkazy ešte slabšie. Glyfosát či parakvát sa používajú aj tam, kde CKDu nie je, takže by museli pôsobiť spolu s ďalším regionálnym faktorom. Koncentrácie agrochemikálií ani kovov namerané v moči nesúviseli s poklesom eGFR v severozápadnej Nikarague. Dysmorfické lyzozómy v biopsiách, interpretované ako stopa toxickej expozície, sa v ďalších súboroch nepotvrdili ako špecifický nález [1].</p>
<p>Autori pripomínajú epidemiologickú skúsenosť. Väčšina chorôb má viacero príčin, epidémie však spravidla vysvetľuje zmena jedného faktora, ako to bolo pri fajčení a rakovine pľúc v 20. storočí. Pri balkánskej endemickej nefropatii trvalo viac ako 40 rokov, kým sa ako kľúčová príčina potvrdila kyselina aristolochová z pšeničnej múky kontaminovanej semenami vlkovca obyčajného (<em>Aristolochia clematitis</em>) [1].</p>

<h2>Ako príčinu hľadať</h2>
<p>Prehľad navrhuje postupný výskum, v ktorom každý ďalší krok vyžaduje viac zdrojov a odôvodňuje ho pozitívny výsledok predchádzajúceho. Štandardizované prierezové prieskumy pomáhajú vylučovať vysvetlenia: expozícia bežná v oblastiach s epidémiou aj bez nej epidémiu sotva vysvetlí. Spúšťač však treba hľadať pri začiatku ochorenia. Spoľahlivý biomarker skorého tubulointersticiálneho poškodenia zatiaľ neexistuje a doterajšie údaje nepodporujú žiadny tubulárny marker v moči. Alternatívou je opakované meranie eGFR u zdanlivo zdravých ľudí z rizikových populácií a analýza expozícií v čase prvého poklesu. Je to náročné a výsledok skresľuje obličková rezerva mladých dospelých [1].</p>
<p>Osobitnú pozornosť si zasluhujú série pacientov z postihnutých oblastí s akútnym poškodením obličiek a biopticky dokázanou akútnou intersticiálnou nefritídou. Vzťah týchto epizód k populačnej záťaži CKDu nie je jasný, môžu však obsahovať etiologické stopy. Podrobné fenotypovanie pri vzniku ochorenia, od bežnej biochémie po genomiku a proteomiku, považujú autori za sľubnejšie než ďalšie dotazníkové štúdie. Spoľahlivý záver podľa nich prinesie až zhoda viacerých nezávislých typov dôkazov [1].</p>
<p>Autori otvorene pomenúvajú aj nerovnosť vo výskume. Miestnym výskumníkom chýbajú zdroje a infraštruktúra. Odporúčajú primerané financovanie, kompenzáciu účastníkov, vyhradený výskumný čas pre miestnych odborníkov a vedenie projektov ľuďmi z postihnutých regiónov [1].</p>

<h2>Čo robiť pre pacientov už teraz</h2>
<p>Ľudí s poruchou funkcie obličiek z postihnutých oblastí treba včas odoslať na odborné vyšetrenie. Diagnóza umožňuje edukáciu, optimalizáciu liečby a zváženie iných príčin vrátane biopsie, ak je indikovaná. Zároveň poskytuje údaje pre plánovanie zdravotných služieb [1]. Komunitné programy zamerané na povedomie o CKD znížili užívanie nesteroidových antireumatík a iných potenciálnych nefrotoxínov v rizikových populáciách mimo oblastí s CKDu. Pracovné opatrenia proti tepelnej záťaži znižujú výskyt poškodenia obličiek u pracovníkov na cukrovej trstine [1, 4].</p>
<p>Inhibítory systému renín-angiotenzín a inhibítory SGLT2 sa pri CKDu skúmali len výnimočne. Autori uvádzajú dôvody, prečo nemusia byť rovnako prínosné ako pri iných formách CKD: riziko intravaskulárnej deplécie objemu a glomerulovej hypoperfúzie a chýbajúcu albuminúriu, ktorá v klinických štúdiách predpovedá odpoveď na liečbu. Potrebné sú dostatočne silné randomizované štúdie. Liečba komplikácií, napríklad anémie alebo dny, sa riadi rovnakými zásadami ako pri CKD známej príčiny [1].</p>

<h2>Limity</h2>
<p>Ide o naratívny, nie systematický prehľad. Autori zámerne vyberajú informatívne práce a podrobne rozoberajú najmä tepelnú záťaž. Viacerí z nich sú spoluautormi citovaných štúdií vrátane projektu DEGREE, nepálskeho prieskumu a analýzy DAPA-CKD, takže výklad odráža aj ich vlastný výskumný program. Záver o horúčave ako faktore zhoršujúcom ochorenie je interpretáciou súhrnu observačných a intervenčných údajov, nie výsledkom jednej rozhodujúcej štúdie.</p>

<h2>Záver</h2>
<p>CKDu zostáva nevyriešenou otázkou globálnej nefrológie. Súvislosť s horúčavou je reálna a pracovné opatrenia majú zmysel, príčinu epidemických zhlukov však treba ešte nájsť. Dovtedy sa starostlivosť o pacientov opiera o všeobecné zásady liečby CKD a o ochranu pred faktormi, ktoré pokles funkcie obličiek urýchľujú.</p>
<p><small><em>Článok je určený zdravotníckym pracovníkom a nenahrádza individuálne klinické posúdenie.</em></small></p>
<hr>
<p><small><em><strong>Zdroj:</strong> [1] Ben Caplin, Prabhdeep Kaur, Thilanga Ruwanpathirana, Neil Pearce, Marvin Gonzalez-Quiroz. The "Known Unknowns" of CKD of Undetermined Etiology In 2026: A Review. Am J Kidney Dis. 2026. 88(6), 993-1002. <a href="https://doi.org/10.1053/j.ajkd.2026.05.025" target="_blank" rel="noopener noreferrer">DOI 10.1053/j.ajkd.2026.05.025</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42772347/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://www.ajkd.org/article/S0272-6386(26)01124-8/fulltext" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></p>
<p><small><em>[2] Charlotte E Rutter, Mary Njoroge, Philip J Cooper, Dorairaj Prabhakaran, Vivekanand Jha, Prabhdeep Kaur, Sailesh Mohan, Ravi Raju Tatapudi, Annibale Biggeri, Peter Rohloff, Michelle H Hathaway, Amelia C Crampin, Meghnath Dhimal, Anil Poudyal, Antonio Bernabe-Ortiz, Cristina O'Callaghan-Gordo, Pubudu Chulasiri, Nalika Gunawardena, Thilanga Ruwanpathirana, S C Wickramasinghe, Sameera Senanayake, Chagriya Kitiyakara, Marvin Gonzalez-Quiroz, Sandra Cortés, Kristina Jakobsson, Ricardo Correa-Rotter, Jason Glaser, Ajay Singh, Sophie Hamilton, Devaki Nair, Aurora Aragón, Dorothea Nitsch, Steven Robertson, Ben Caplin, Neil Pearce, DEGREE Study Group. International prevalence patterns of low eGFR in adults aged 18-60 without traditional risk factors from a population-based cross-sectional disadvantaged populations eGFR epidemiology (DEGREE) study. Kidney Int. 2025. 107(3), 541-557. <a href="https://doi.org/10.1016/j.kint.2024.11.028" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.kint.2024.11.028</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/39708999/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://www.kidney-international.org/article/S0085-2538(24)00910-4/fulltext" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></p>
<p><small><em>[3] Nirmal Aryal, Pramod R Regmi, Arun Sedhain, Sankalpa Bhattarai, Radheshyam Krishna Kc, Shravan Kumar Mishra, Ben Caplin, Neil Pearce, Edwin van Teijlingen. A comparison of chronic kidney risk among returnee Nepalese migrant workers in the countries of the Gulf and Malaysia and non-migrants in Nepal: a population-based cross-sectional study. BMC Nephrol. 2026. 27(1), 263. <a href="https://doi.org/10.1186/s12882-026-04872-7" target="_blank" rel="noopener noreferrer">DOI 10.1186/s12882-026-04872-7</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/41851648/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://bmcnephrol.biomedcentral.com/articles/10.1186/s12882-026-04872-7" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></p>
<p><small><em>[4] Jason Glaser, Erik Hansson, Ilana Weiss, Catharina Wesseling, Kristina Jakobsson, Ulf Ekström, Jenny Apelqvist, Rebekah Lucas, Esteban Arias Monge, Sandra Peraza, Christer Hogstedt, David H Wegman. Preventing kidney injury among sugarcane workers: promising evidence from enhanced workplace interventions. Occup Environ Med. 2020. 77(8), 527-534. <a href="https://doi.org/10.1136/oemed-2020-106406" target="_blank" rel="noopener noreferrer">DOI 10.1136/oemed-2020-106406</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/32404530/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7402461/" target="_blank" rel="noopener noreferrer">PMC</a>.</em></small></p>
<p><small><em>[5] Zhiyan Zhang, Hiddo J L Heerspink, Glenn M Chertow, Ricardo Correa-Rotter, Antonio Gasparrini, Niels Jongs, Anna Maria Langkilde, John J V McMurray, Malcolm N Mistry, Peter Rossing, Robert D Toto, Priya Vart, Dorothea Nitsch, David C Wheeler, Ben Caplin. Ambient heat exposure and kidney function in patients with chronic kidney disease: a post-hoc analysis of the DAPA-CKD trial. Lancet Planet Health. 2024. 8(4), e225-e233. <a href="https://doi.org/10.1016/S2542-5196(24)00026-3" target="_blank" rel="noopener noreferrer">DOI 10.1016/S2542-5196(24)00026-3</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38580424/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://www.thelancet.com/journals/lanplh/article/PIIS2542-5196(24)00026-3/fulltext" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></p>
<p><small><em><strong>Poznámka k dôkazom:</strong> Prehľad [1] je voľne dostupný a bol prečítaný v plnom znení vrátane tabuliek a zoznamu literatúry. Autorské zoznamy, ročníky, strany a identifikátory všetkých zdrojov boli overené v PubMed. Údaje nepálskeho prieskumu, intervenčnej štúdie zo Salvádoru a analýzy DAPA-CKD boli overené v abstraktoch pôvodných prác. Údaj o severovýchodnom Thajsku preberáme z prehľadu bez samostatného overenia pôvodnej práce.</em></small></p>
<h3>Súvisiace články</h3>
<ul>
<li><a href="article.php?slug=ckdnt-pracovnici-horucava-texas-nejasna-etiologia">Chronická choroba obličiek nejasnej etiológie u pracovníkov vystavených horúčave</a></li>
<li><a href="article.php?slug=extremne-horucavy-riziko-ckd-dialyza">Extrémne horúčavy a riziko pri CKD a dialýze</a></li>
<li><a href="article.php?slug=environmentalne-toxiny-poskodenie-obliciek-nefrolog">Environmentálne toxíny a poškodenie obličiek</a></li>
</ul>
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
    'log_prefix' => 'add_ckdu-neznama-etiologia-2026_article',
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
