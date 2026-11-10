<?php
/**
 * Metodické pokračovanie: odborná kontrola a hodnotenie AI vo výučbe nefrológie.
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
    'title'        => 'AI vo výučbe nefrológie: od kazuistiky k overeniu samostatných schopností',
    'slug'         => 'ai-nefrologicka-vyucba-kazuistika-hodnotenie',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Ako pripraviť a odborne skontrolovať nefrologickú kazuistiku s AI, vyhodnotiť samostatný výkon účastníka a navrhnúť pilot bez preceňovania výsledkov.',
    'content'      => <<<'HTML'
<figure><a href="img/ai-medicinske-vzdelavanie-nefrologia.webp" rel="noopener noreferrer" target="_blank"><img src="img/ai-medicinske-vzdelavanie-nefrologia.webp" alt="Ľudská a digitálna ruka pod otvorenou knihou so svetelným modelom obličiek." width="1586" height="992" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna spája nefrologické vzdelávanie s odborným dohľadom nad digitálnymi nástrojmi. Nezobrazuje konkrétneho pacienta ani existujúci výrobok.</figcaption></figure>

<p>O prínose umelej inteligencie vo výučbe rozhoduje to, čo účastník po skončení nácviku dokáže samostatne vysvetliť, posúdiť a obhájiť. Plynulý rozhovor so simulátorom ani priaznivý dotazník tento výsledok nenahrádzajú. Pri zavádzaní do nefrologického vzdelávania preto treba vopred určiť cieľ, pripraviť odborne skontrolovaný scenár a oddeliť výkon s pomocou systému od výkonu bez jeho pomoci.</p>

<p>Predchádzajúci <a href="article.php?slug=umela-inteligencia-nefrologicke-vzdelavanie-dokazy-hranice">prehľad dôkazov o AI v nefrologickom vzdelávaní</a> sa venoval výsledkom štúdií. Toto pokračovanie navrhuje postup prípravy a hodnotenia konkrétnej výučbovej aktivity. Ide o autorskú metodickú syntézu určenú na miestne overenie, nie o validovaný vzdelávací program ani klinický liečebný algoritmus.</p>

<h2>Najprv pomenovať schopnosť, ktorú má výučba rozvíjať</h2>
<p>Cieľ „naučiť sa pracovať s AI“ je na hodnotenie príliš široký. Presnejšie zadanie môže znieť: účastník rozpozná, ktoré údaje v nefrologickej kazuistike chýbajú, vysvetlí ich význam a odlíši podložený záver od predpokladu. Iná aktivita môže cieliť na zrozumiteľné vysvetlenie možností starostlivosti alebo na kontrolu chybného výpočtu. Tieto schopnosti sa nemajú zlúčiť do jediného skóre bez vysvetlenia, čo výsledok vyjadruje.</p>

<p>Rozlišovanie cieľov má oporu aj v systematickom prehľade 66 randomizovaných štúdií so 4 911 účastníkmi. Istota dôkazov bola nízka až veľmi nízka a žiadna zahrnutá štúdia neposudzovala zmenu správania v klinickej praxi ani konečné výsledky podľa tretej a štvrtej úrovne Kirkpatrickovho modelu. Úspech pri výučbovej úlohe preto nemožno bez ďalšieho vydávať za zlepšenie starostlivosti o pacienta. Prehľad navyše zachytával literatúru iba do 26. januára 2026. [1]</p>

<h2>Vstupné riešenie bez pomoci systému</h2>
<p>Pred prvým rozhovorom s virtuálnym pacientom účastník stručne zaznamená vlastné hodnotenie prípadu: čo vie, čo potrebuje zistiť a prečo. Pedagóg tak získa východisko na porovnanie. Podľa cieľa môže povoliť vopred určené odborné materiály alebo kalkulačku; podstatné je, aby boli podmienky jasné a rovnaké pre porovnávaných účastníkov. Výkon bez AI neznamená automaticky skúšanie všetkého naspamäť.</p>

<p>Ke a spoluautori v odbornom komentári rozlišujú tri riziká: oslabovanie už získaných schopností, osvojenie chybných poznatkov a nevytvorenie základných schopností pre predčasné spoliehanie sa na AI. Posledné riziko označujú ako „never-skilling“. Nejde o preukázaný výskyt poškodenia u študentov medicíny: autori výslovne uvádzajú, že priame dôkazy z medicínskeho vzdelávania chýbajú. Navrhujú najprv overiť základnú samostatnú spôsobilosť, potom nacvičovať kritické posudzovanie AI a až následne jej používanie pod dohľadom. Tento rámec je výskumným návrhom, nie potvrdeným účinným poradím výučby. [2]</p>

<h2>Kazuistika potrebuje pevné odborné jadro</h2>
<p>Pri pilotnej aktivite je účelné použiť úplne fiktívny prípad. Pred jeho sprístupnením pedagóg schváli časový priebeh, výsledky vyšetrení, jednotky, dostupné informácie a očakávané zdôvodnenie. Určí aj to, čo zo zadania nemožno rozhodnúť. Ak sa napríklad prípad týka zmeny kreatinínu, čas odberov a predchádzajúce hodnoty nemajú zostať náhodnou improvizáciou simulátora.</p>

<p>Rozhovor môže byť jazykovo premenlivý, jeho klinické jadro však musí zostať konzistentné. Pre začiatočný pilot navrhujeme vopred pripraviť prípustné odpovede na hlavné otázky a odbočenie mimo scenára označiť namiesto dopĺňania nových „faktov“. Takéto obmedzenie zjednodušuje kontrolu; samo osebe nezaručuje správnosť generovaného textu.</p>

<div class="table-responsive" role="region" aria-label="Odborná kontrola nefrologickej výučbovej kazuistiky" tabindex="0">
<table><thead><tr><th scope="col">Oblasť</th><th scope="col">Čo má pedagóg overiť</th><th scope="col">Čo má účastník preukázať</th></tr></thead><tbody>
<tr><th scope="row">Časový priebeh</th><td>Vzájomný súlad anamnézy, odberov a priebehu ťažkostí.</td><td>Pomenovať údaje, bez ktorých je záver predčasný.</td></tr>
<tr><th scope="row">Veličiny a jednotky</th><td>Konzistentný zápis, prípadné prepočty a referenčné údaje.</td><td>Vysvetliť použitú veličinu a skontrolovať výpočet.</td></tr>
<tr><th scope="row">Odborné pojmy</th><td>Presné rozlišovanie albuminúrie a proteinúrie, odhadovanej glomerulovej filtrácie a klírensu kreatinínu.</td><td>Použiť pojem, ktorý zodpovedá údajom v prípade.</td></tr>
<tr><th scope="row">Zdroj záveru</th><td>Súlad očakávanej odpovede s určeným aktuálnym odborným zdrojom.</td><td>Uviesť podklad a hranice jeho použiteľnosti.</td></tr>
<tr><th scope="row">Komunikácia</th><td>Zrozumiteľnosť scenára, priestor pre pacientove priority a otázky.</td><td>Overiť porozumenie a reagovať na konkrétnu obavu.</td></tr>
<tr><th scope="row">Neistota</th><td>Vopred pomenované neznáme údaje a prijateľné alternatívne vysvetlenia.</td><td>Priznať neistotu a zdôvodniť ďalší krok.</td></tr>
</tbody></table></div>

<p>Tabuľka je pracovným kontrolným zoznamom pre túto metodiku. Nie je validovanou hodnotiacou škálou a neustanovuje diagnostické ani liečebné kritériá. Konkrétne klinické odpovede a rozhodovacie hranice treba pre každú kazuistiku osobitne overiť.</p>

<h2>Kontrola otázok sa nekončí pri správnej odpovedi</h2>
<p>AI môže pomôcť pripraviť návrh testu, ale každú otázku treba skontrolovať vecne aj didakticky. V štúdii Camaratu a spoluautorov, ktorá sa týkala otázok z fyziológie obličiek, obsahovalo 49 % hodnotených otázok nedostatky v konštrukcii a 22 % vecné alebo pojmové chyby. Zároveň bolo 59 zo 65 otázok hodnotených ako použiteľný východiskový materiál na úpravu. Tieto kategórie sa nevylučujú; nejde ani o odhad chybovosti všetkých dnešných modelov. [3]</p>

<p>Pri kontrole otázky pedagóg preverí, či zadanie obsahuje všetky potrebné údaje, či existuje jednoznačne najlepšia odpoveď a či nesprávne možnosti neprezrádza gramatika alebo odlišná dĺžka. Skontroluje aj vysvetlenie každej možnosti. Správne označená odpoveď s chybným zdôvodnením je nevhodný učebný materiál. Účastník má mať možnosť upozorniť na nejednoznačnosť bez toho, aby systém jeho námietku automaticky hodnotil ako nevedomosť.</p>

<h2>Rozbor s pedagógom a skúška na novom prípade</h2>
<p>Po nácviku účastník porovná svoje pôvodné riešenie s tým, čo prijal od systému. Pri každej významnej zmene uvedie dôvod a odborný podklad. Pedagóg rozoberie aj situácie, v ktorých presvedčivá formulácia zakrývala chýbajúci údaj alebo nepodložený záver. Cieľom je zistiť, podľa čoho sa účastník rozhodol, nielen či sa jeho odpoveď zhoduje s pripraveným riešením.</p>

<p>Následná samostatná úloha má byť obsahovo príbuzná, ale nemá iba opakovať tú istú kazuistiku s iným menom. Môže zmeniť poradie dostupných informácií, pridať relevantný rozpor alebo požadovať vysvetlenie pre pacienta. Skúška s odstupom potom preverí zachovanie vedomostí. Časový odstup treba určiť vopred podľa cieľa kurzu; tento článok nestanovuje univerzálne optimálny interval.</p>

<p>Pri komunikačnej aktivite je vhodné zaradiť hodnotenie rozhovoru s človekom, napríklad so štandardizovaným pacientom, teda osobou vyškolenou na stvárnenie scenára. Samotné skóre pridelené chatbotom nemá byť jediným podkladom rozhodnutia o spôsobilosti účastníka. Hodnotitelia potrebujú konkrétne opísané kritériá a predbežné zosúladenie hodnotenia na rovnakých ukážkach.</p>

<h2>Ako navrhnúť pilot, aby odpovedal na užitočnú otázku</h2>
<p>Ak chceme posúdiť pridaný účinok AI, porovnávacia skupina potrebuje primerane podobný čas na učenie, obsah a prístup k spätnej väzbe. Inak zostane neisté, či rozdiel spôsobila technológia alebo väčší objem nácviku. Vopred treba vybrať hlavný výsledok, spôsob jeho hodnotenia a pravidlá spracovania chýbajúcich údajov. Veľkosť súboru sa má odvíjať od cieľa a požadovanej presnosti, nie od ľubovoľného počtu dostupných študentov.</p>

<p>V malom pilote môže byť primeraným cieľom overiť uskutočniteľnosť: dokončenie úloh, čas pedagóga, zrozumiteľnosť hodnotenia a počet odborných chýb. Takýto pilot však spravidla neodpovie spoľahlivo na otázku účinnosti. Výsledky treba uvádzať aj s neistotou a rozlišovať vopred plánované hodnotenie od dodatočného hľadania priaznivých rozdielov.</p>

<h2>Verzie, ochrana údajov a podmienky prerušenia</h2>
<p>Pre každý beh aktivity navrhujeme uchovať dátum, verziu scenára, označenie použitého modelu, zadanie, schválené zdroje a hodnotiace kritériá. Po zmene systému treba znovu preveriť pripravené kontrolné situácie. Účastníci majú vedieť, na čo sa ich rozhovory používajú, kto k nim má prístup a ako dlho sa uchovávajú. Aj fiktívna klinická kazuistika môže sprevádzať identifikovateľný záznam výkonu študenta.</p>

<p>Pred spustením treba určiť postup pri vecnej chybe, rozpore v scenári alebo nevhodnom výstupe. Praktickým pravidlom môže byť prerušenie používania dotknutého scenára do jeho odbornej opravy a preverenie, či chyba neovplyvnila hodnotenie účastníkov. Ide o navrhovanú organizačnú podmienku, nie o výsledok porovnávacej štúdie.</p>

<p>Kompetenčný rámec AAMC z októbra 2026 podporuje kritické hodnotenie nástrojov, rozpoznávanie ich obmedzení a zodpovedné používanie AI. Poskytuje orientáciu pri tvorbe cieľov a formatívneho hodnotenia, ale nepotvrdzuje účinnosť konkrétneho produktu. [4] Pre nefrologické pracovisko tak zostáva rozhodujúce miestne overenie: čo sa účastník naučil, čo vie zdôvodniť a čo dokáže bezpečne zvládnuť bez priebežnej pomoci systému.</p>

<h2>Hranice navrhnutého postupu</h2>
<p>Predložená metodika nebola v tejto podobe skúšaná ako celok. Spája poznatky o limitoch dostupných štúdií s autorskými návrhmi na prípravu, odbornú kontrolu a hodnotenie výučby. Neurčuje hranicu úspešnosti skúšky, oprávnenie na samostatnú klinickú činnosť ani jednotný štandard pre všetky stupne vzdelávania. Tieto rozhodnutia patria zodpovedným pedagógom a príslušnej vzdelávacej ustanovizni.</p>

<hr>
<p><em>Článok je určený zdravotníckym pracovníkom a pedagógom. Výučbové návrhy nenahrádzajú odborné odporúčania pre starostlivosť o konkrétneho pacienta.</em></p>
<h2>Literatúra</h2>
<ol>
<li><small><em>Nai Ming Lai, Yin Sear Lim, Min Thein Win, Prabal Bhargava, Paraidathathu Thomas, Qi Chwen Ong. The Effectiveness of Artificial Intelligence in Undergraduate Health Professions Education: Systematic Review and Meta-Analysis of Randomized Controlled Trials. JMIR Medical Education. 2026;12:e88933. <a href="https://mededu.jmir.org/2026/1/e88933/" target="_blank" rel="noopener noreferrer">Vydavateľ</a>. DOI: <a href="https://doi.org/10.2196/88933" target="_blank" rel="noopener noreferrer">10.2196/88933</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42085678/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Yuhe Ke, Liyuan Jin, Jasmine Chiat Ling Ong, Arun J Thirunavukarasu, Josip Car, Carol Y Cheung, Yih Chung Tham, Daniel Shu Wei Ting, Marcus Eng Hock Ong, Scott Compton, Aditee Narayan, Pearse A Keane, Tien Yin Wong, David W Bates, Patrick Tan, Nan Liu. AI-induced never-skilling in medical education. Nature Medicine. 2026;32(6):1997-2006. <a href="https://www.nature.com/articles/s41591-026-04438-y" target="_blank" rel="noopener noreferrer">Vydavateľ</a>. DOI: <a href="https://doi.org/10.1038/s41591-026-04438-y" target="_blank" rel="noopener noreferrer">10.1038/s41591-026-04438-y</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42174254/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Troy Camarata, Lise McCoy, Robert Rosenberg, Kelsey R Temprine Grellinger, Kylie Brettschnieder, Jonathan Berman. LLM-Generated multiple choice practice quizzes for preclinical medical students. Advances in Physiology Education. 2025;49(3):758-763. <a href="https://journals.physiology.org/doi/10.1152/advan.00106.2024" target="_blank" rel="noopener noreferrer">Vydavateľ</a>. DOI: <a href="https://doi.org/10.1152/advan.00106.2024" target="_blank" rel="noopener noreferrer">10.1152/advan.00106.2024</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/40516963/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Lisa Howley, Kamilah Weems, Dallas Peoples, Alison J. Whelan. AI Competencies Across the Learning Continuum. Association of American Medical Colleges. 27. októbra 2026. <a href="https://www.aamc.org/about-us/medical-education/cbme/publication/ai-competencies-across-learning-continuum" target="_blank" rel="noopener noreferrer">Oficiálny dokument vydavateľa</a>.</em></small></li>
</ol>
<p><small><em>Poznámka k dôkazom: Bibliografické údaje a abstrakty prác Ke a spoluautorov a Camaratu a spoluautorov boli overené v PubMed; ich plné texty neboli pri príprave dostupné. Pri systematickom prehľade boli overené aj dostupné metodické a výsledkové časti vydavateľa, pri AAMC oficiálny dokument. Tabuľka, organizácia pilotu a konkrétne kontrolné postupy sú autorskou syntézou na miestne overenie. Stav zdrojov: 10. novembra 2026.</em></small></p>
<h3>Súvisiaci článok</h3>
<p><a href="article.php?slug=umela-inteligencia-nefrologicke-vzdelavanie-dokazy-hranice">Umelá inteligencia v nefrologickom vzdelávaní: možnosti, dôkazy a hranice</a></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// Na výslovný pokyn používateľa sa pri publikovaní nezaraďujú e-mailové avíza.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ai-nefrologicka-vyucba-kazuistika-hodnotenie_article',
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
