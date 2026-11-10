<?php
/**
 * Odborný prehľad: umelá inteligencia v nefrologickom vzdelávaní.
 * Vecná a jazyková revízia: 10. novembra 2026.
 * Publikovanie bez automatických e-mailových avíz.
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
    'title'        => 'Umelá inteligencia v nefrologickom vzdelávaní: možnosti, dôkazy a hranice',
    'slug'         => 'umela-inteligencia-nefrologicke-vzdelavanie-dokazy-hranice',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Virtuálni pacienti a jazykové modely rozširujú možnosti výučby. Prehľad dôkazov vysvetľuje ich prínos, obmedzenia a podmienky odborného využitia v nefrologickom vzdelávaní.',
    'content'      => <<<'HTML'
<figure><a href="img/umela-inteligencia-nefrologicke-vzdelavanie-dokazy-hranice.webp" rel="noopener noreferrer" target="_blank"><img src="img/umela-inteligencia-nefrologicke-vzdelavanie-dokazy-hranice.webp" alt="Poloschematický svetelný model obličiek nad učebnicou a ruka lekára pri ovládači digitálnej simulácie." width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna: digitálna simulácia ako pomôcka pri výučbe nefrológie pod odborným dohľadom. Nezobrazuje konkrétneho pacienta ani existujúci prístroj.</figcaption></figure>

<p>Generatívna umelá inteligencia môže rozšíriť možnosti samostatnej prípravy, tvorby výučbových materiálov a nácviku rozhovorov s pacientom. Doterajšie výsledky však neoprávňujú zamieňať spokojnosť študentov, lepší výkon pri jednej úlohe a trvalé zlepšenie klinických schopností. Pre nefrologické vzdelávanie je preto podstatné, čo sa študent naučí a dokáže samostatne použiť, nie iba to, ako presvedčivo s ním systém komunikuje.</p>

<h2>Čo dokladajú súhrnné výsledky</h2>
<p>Systematický prehľad autorov Lai, Lim, Win, Bhargava, Thomas a Ong zahrnul 66 randomizovaných štúdií so 4 911 účastníkmi pregraduálneho vzdelávania zdravotníckych profesií. Vyhľadávanie pokrývalo literatúru do 26. januára 2026, preto tento prehľad nezahŕňa všetky neskôr publikované práce. Istota dôkazov bola nízka až veľmi nízka. Pri personalizovaných vzdelávacích pomôckach využívajúcich veľké jazykové modely bol účinok na teoretické vedomosti priaznivý: štandardizovaný rozdiel priemerov 0,53, 95 % interval spoľahlivosti 0,13 až 0,94. Výsledky 12 štúdií s 955 účastníkmi sa však výrazne líšili (I² = 86 %) a istota tohto konkrétneho dôkazu bola veľmi nízka. [1]</p>
<p>Žiadna zo zahrnutých štúdií nehodnotila tretiu ani štvrtú úroveň Kirkpatrickovho modelu, teda zmenu správania v praxi a konečné výsledky. Zistenia preto nepreukazujú lepšiu starostlivosť o pacientov. Navyše sa týkajú rôznych technológií a vzdelávacích prostredí; nemožno ich preniesť na každý nový produkt ani automaticky na špecializačné vzdelávanie v nefrológii. [1]</p>

<h2>Tutor viazaný na učivo: lepšia príprava, neisté dlhodobejšie zapamätanie</h2>
<p>Roark a spoluautori skúmali u 44 študentov druhého ročníka medicíny konverzačný nástroj prispôsobený konkrétnemu učivu patológie. V pilotnej randomizovanej štúdii so skríženým usporiadaním každý študent pri jednej z dvoch kazuistík použil tento nástroj a pri druhej bežné zdroje. Systém podporoval samostatné učenie postupnými otázkami. Hodnotenie dokumentácie prípravy bolo priaznivejšie pri použití nástroja: 10,3 oproti 9,4 bodu z 12; rozdiel 0,9 bodu, 95 % interval spoľahlivosti 0,5 až 1,3. Zlepšilo sa aj hodnotenie výkonu v skupinovej diskusii. Rozdiel v neskoršom vedomostnom teste však v primárnej analýze nebol štatisticky významný (p = 0,052). [2]</p>
<p>Ide o výsledok z jedného pracoviska a dvoch patologických kazuistík, nie o potvrdenie všeobecnej účinnosti virtuálneho učiteľa. V nefrologickej výučbe by sa dal obdobný postup skúšať pri vysvetľovaní patofyziologických súvislostí. Jeho účinnosť by však bolo potrebné osobitne overiť, vrátane samostatného riešenia nového prípadu bez pomoci systému.</p>

<h2>Virtuálny pacient a rozhovor o závažnom ochorení</h2>
<p>Štúdia Hauta a spoluautorov poskytla dôkaz o krátkodobom zlepšení komunikačného výkonu v simulovanom prostredí. Päťdesiatjeden študentov a zdravotníckych pracovníkov absolvovalo buď približne 30-minútový tréning s virtuálnym pacientom SOPHIE, alebo rovnako dlhé štúdium písomného materiálu. Následný výkon pri rozhovore so štandardizovaným pacientom hodnotili zaslepení hodnotitelia. Štandardizovaný pacient je človek vyškolený na stvárnenie určitého klinického scenára. [3]</p>
<p>Skupina so SOPHIE dosiahla väčšie zlepšenie celkového komunikačného skóre; odhad dodatočného zlepšenia oproti kontrole bol β = 0,09, s 95 % intervalom spoľahlivosti 0,04 až 0,14. Tento koeficient nie je percentuálne zlepšenie klinickej úspešnosti. Hodnotenie sa uskutočnilo v ten istý deň a porovnávacou intervenciou bolo čítanie, nie interaktívny tréning s človekom. Nie je preto známe, či účinok pretrváva a prenáša sa do skutočných rozhovorov. Systém navyše pri hodnotení nezohľadňoval mimiku, intonáciu a reč tela účastníka. [3]</p>
<p>Pre nefrológiu sa ponúka nácvik rozhovoru o progresii chronickej choroby obličiek, možnostiach náhrady funkcie obličiek alebo konzervatívnej starostlivosti. Sú to návrhy využitia, nie situácie, pre ktoré táto štúdia preukázala účinnosť. Výučba by mala hodnotiť aj zistenie pacientových priorít, overenie porozumenia a rešpektovanie jeho rozhodovania. Samotná plynulosť rozhovoru nestačí.</p>

<h2>Ročné sledovanie neprinieslo presvedčivú výhodu simulátora</h2>
<p>Wang a spoluautori sledovali 50 študentov medicíny počas akademického roka. Dvadsiati dvaja boli zaradení do skupiny s prístupom k simulátoru SimPatient a 28 do kontrolnej skupiny. Medziskupinový rozdiel vo vývoji komunikačného výkonu nebol štatisticky významný. Skúškové stanice z jednotlivých rokov navyše neboli formálne vyrovnané z hľadiska porovnateľnosti; ani celkový vzostup skóre vzhľadom na hranicu úspešnosti nebol štatisticky významný. Nemožno preto bez výhrady tvrdiť, že štúdia preukázala zlepšenie schopností počas roka. [4]</p>
<p>Malá vzorka zároveň neumožňuje uzavrieť, že simulátor nemá nijaký účinok. Výsledok ukazuje, že jeho pridaný prínos nebol spoľahlivo doložený. Spokojnosť používateľov ani veľký počet uskutočnených rozhovorov tento chýbajúci dôkaz nenahrádzajú. [4]</p>

<h2>Tvorba kazuistík a otázok vyžaduje odbornú kontrolu</h2>
<p>Bantidos a spoluautori randomizovane porovnali u 131 študentov dve virtuálne kardiologické kazuistiky: jednu vytvorenú lekármi a druhú vytvorenú pomocou GPT-5 a následne upravovanú ďalšími zadaniami pod odborným dohľadom. Kazuistika vytvorená s pomocou modelu získala priaznivejšie hodnotenie vierohodnosti a nižšej vnímanej kognitívnej záťaže. Hodnotili sa však predovšetkým dojmy študentov, nie objektívne vedomosti či dlhodobejšie zapamätanie. Porovnanie jednej dvojice scenárov nepreukazuje všeobecnú prevahu takto pripravovaných materiálov ani úsporu času pri ich tvorbe. [5]</p>
<p>Priamo k výučbe fyziológie obličiek sa vzťahuje práca Camaratu a spoluautorov. Odborníci posúdili 65 testových otázok vytvorených pomocou ChatGPT: 49 % obsahovalo nedostatky v konštrukcii otázky a 22 % vecné alebo pojmové chyby. Napriek tomu bolo 59 otázok, teda 91 %, hodnotených ako rozumný východiskový materiál na prepracovanie. Tieto kategórie sa nevylučujú. Výsledok podporuje prípravu návrhov pod dohľadom odborníka, nie preberanie otázok bez kontroly. Údaje pochádzajú z konkrétneho súboru otázok a nemožno ich považovať za chybovosť všetkých súčasných modelov. [6]</p>
<p>Pri nefrologickej kazuistike by mal kontrolujúci lekár posúdiť súlad časového priebehu, laboratórnych hodnôt, jednotiek a očakávanej odpovede. Osobitnú pozornosť si zaslúži rozlišovanie akútneho poškodenia obličiek a chronickej choroby obličiek, albuminúrie a proteinúrie či odhadovanej glomerulovej filtrácie a klírensu kreatinínu. Ide o navrhované kontrolné body pre výučbu, nie o nový diagnostický algoritmus.</p>

<h2>Herné prvky: povzbudivé, ale predbežné údaje</h2>
<p>Yaning Lai, Xiaoqin Lai a Hai Hu retrospektívne porovnali 86 študentov troch po sebe nasledujúcich ročníkov vo výučbe reakcie na urgentné situácie. Výsledky naznačili priaznivejšie neskoršie zapamätanie pri hernej výučbe doplnenej generatívnou umelou inteligenciou. Keďže jednotlivé spôsoby výučby zodpovedali odlišným ročníkom a nešlo o randomizáciu, účinok technológie nemožno spoľahlivo oddeliť od ostatných rozdielov medzi skupinami. Zistenie je podnetom na ďalšie skúmanie. [7]</p>

<h2>Ako pripraviť zmysluplný nefrologický pilotný program</h2>
<p>Rámec kompetencií AAMC z októbra 2026 zdôrazňuje kritické hodnotenie výstupov, profesionálnu zodpovednosť, ochranu údajov a zachovanie základných zručností. Upozorňuje aj na riziko, že si študent pri predčasnom spoliehaní sa na technológiu niektoré zručnosti vôbec neosvojí. Je to rámec pre tvorbu vzdelávania, nie klinické odporúčanie ani dôkaz účinnosti konkrétneho nástroja. [8]</p>
<p>Na tomto základe možno navrhnúť malý, vopred ohraničený nefrologický program. Pedagóg najprv určí jednu schopnosť, ktorú má študent zvládnuť, pripraví vzorové riešenie a pravidlá hodnotenia. Následne vytvorí fiktívny prípad s overenými podkladmi. Pred použitím skontroluje všetky rozhodovacie vetvy vrátane nesprávnych odpovedí a zavádzajúcich otázok. Verziu modelu, dátum, zadanie aj úpravy scenára uchová pre neskoršie porovnanie.</p>
<p>Účastník najprv sformuluje vlastné riešenie, potom pracuje so simulátorom a napokon absolvuje rozbor s pedagógom. Účinok sa hodnotí na novej úlohe bez pomoci umelej inteligencie a s časovým odstupom. Pri komunikačnej výučbe je vhodné zaradiť aj rozhovor s človekom a hodnotiť konkrétne prejavy správania. Takto navrhnutý postup je redakčným návrhom na miestne overenie; jeho účinnosť v tejto podobe citované štúdie neskúmali.</p>
<p>Fiktívne údaje umožňujú pripraviť výučbu bez prenosu skutočných zdravotných záznamov do externých služieb. Odborná kontrola musí zostať súčasťou každej aktualizácie. Obmedzenie zdrojov na schválené materiály samo osebe nezaručuje správnosť odpovede. O úspechu programu má rozhodovať samostatný výkon študenta a zachovanie odborného úsudku.</p>

<h2>Hranice súčasných dôkazov</h2>
<p>Dostupné práce sa líšia cieľovou skupinou, použitou technológiou aj spôsobom hodnotenia. Malé jednocentrové štúdie a krátke sledovanie obmedzujú zovšeobecnenie výsledkov. Prínos pre jednu výučbovú úlohu nepreukazuje pripravenosť na samostatnú klinickú prax. Pri zavádzaní do nefrologického vzdelávania preto zostáva potrebné miestne overenie s vopred určeným cieľom, nezávislým hodnotením a skúškou zachovania vedomostí. [1, 2, 3, 4, 5, 6]</p>

<h2>Literatúra</h2>
<ol>
<li>Nai Ming Lai, Yin Sear Lim, Min Thein Win, Prabal Bhargava, Paraidathathu Thomas, Qi Chwen Ong. The Effectiveness of Artificial Intelligence in Undergraduate Health Professions Education: Systematic Review and Meta-Analysis of Randomized Controlled Trials. <em>JMIR Medical Education.</em> 2026;12:e88933. DOI: <a href="https://doi.org/10.2196/88933" target="_blank" rel="noopener noreferrer">10.2196/88933</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42085678/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
<li>Kasie Roark, Yumin Choi, Elizabeth Hoy, Noel Tufts, Robert Amevor, Rahul Ghosal, Brian Keisler, Leonardo Bonilha, Ioulia Chatzistamou. Curriculum-Aligned Conversational AI to Support Pathology Self-Directed Learning in Preclinical Medical Students: Crossover Randomized Pilot Study. <em>JMIR Medical Education.</em> 2026;12:e102908. DOI: <a href="https://doi.org/10.2196/102908" target="_blank" rel="noopener noreferrer">10.2196/102908</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42873617/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
<li>Kurtis G Haut, Masum Hasan, Thomas Carroll, Ronald M Epstein, Taylan Sen, Ehsan Hoque. Effects of a Generative AI Virtual Patient on Serious Illness Communication Skills: Randomized Controlled Trial. <em>JMIR Medical Education.</em> 2026;12:e93034. DOI: <a href="https://doi.org/10.2196/93034" target="_blank" rel="noopener noreferrer">10.2196/93034</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42902927/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
<li>Xining Wang, Sandhya Duggal, Alun Hughes, Sayed Murad, Andrew O’Malley. Evaluating an AI-Powered Patient Simulator for Communication Skills Training: One-Year Randomized Controlled Trial. <em>Journal of Medical Internet Research.</em> 2026;28:e91886. DOI: <a href="https://doi.org/10.2196/91886" target="_blank" rel="noopener noreferrer">10.2196/91886</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42987316/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
<li>Marios Georgios Bantidos, Eleni Dafli, Efstratios Karagiannidis, Barbara Fyntanidou, Sotiria Gilou, Athina Nasoufidou, Panagiotis Bamidis. Perceived Ratings of AI-Generated and Expert-Reviewed vs Clinician-Developed Virtual Cardiology Patient Scenarios Among Medical Students: Randomized Controlled Study. <em>JMIR Medical Education.</em> 2026;12:e100839. DOI: <a href="https://doi.org/10.2196/100839" target="_blank" rel="noopener noreferrer">10.2196/100839</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42950240/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
<li>Troy Camarata, Lise McCoy, Robert Rosenberg, Kelsey R Temprine Grellinger, Kylie Brettschnieder, Jonathan Berman. LLM-Generated multiple choice practice quizzes for preclinical medical students. <em>Advances in Physiology Education.</em> 2025;49(3):758-763. DOI: <a href="https://doi.org/10.1152/advan.00106.2024" target="_blank" rel="noopener noreferrer">10.1152/advan.00106.2024</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/40516963/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
<li>Yaning Lai, Xiaoqin Lai, Hai Hu. Enhancing Emergency Medical Response Education through Generative AI-Powered Game-Based Learning: A Retrospective Comparative Study. <em>Prehospital and Disaster Medicine.</em> 2026;41(1):e14. DOI: <a href="https://doi.org/10.1017/S1049023X26108978" target="_blank" rel="noopener noreferrer">10.1017/S1049023X26108978</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42458820/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
<li>Lisa Howley, Kamilah Weems, Dallas Peoples, Alison J. Whelan. <em>AI Competencies Across the Learning Continuum.</em> Association of American Medical Colleges. 27. októbra 2026. <a href="https://www.aamc.org/about-us/medical-education/cbme/publication/ai-competencies-across-learning-continuum" target="_blank" rel="noopener noreferrer">Oficiálny dokument AAMC</a>.</li>
</ol>
<p><em>Poznámka k dôkazom: Prehľad vychádza z bibliografických záznamov a abstraktov uvedených publikácií, dostupných metodických a výsledkových častí článkov JMIR a oficiálneho rámca AAMC. Pri prácach Camaratu a spoluautorov a Yaning Lai, Xiaoqin Lai a Hai Hu bol dostupný abstrakt, nie plný text. Návrh nefrologického výučbového programu je vlastnou syntézou a nebol v opísanej podobe klinicky ani pedagogicky overený. Stav podkladov: 10. novembra 2026.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// Na výslovný pokyn používateľa sa pri publikovaní nezaraďujú e-mailové avíza.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ai_nefrologicke_vzdelavanie_article',
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
