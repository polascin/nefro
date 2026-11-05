<?php
/**
 * add_ai-klinicka-prax-strategia-zacina-problemom_article.php
 * Odborný článok: stratégia klinickej umelej inteligencie začína problémom,
 * nie technológiou; ambientná dokumentácia (RCT Lukac a kol.), riadenie
 * životného cyklu a nefrologický kontext.
 * Spracovanie odborného rozhovoru Medscape Digital Health Pulse zo 16. 10. 2026
 * (Abulata, Pandita) s doplnením overených rámcov a primárnych dôkazov.
 * Avíza sa pri tomto článku zámerne NEposielajú ('enqueue_newsletter' => false).
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
    'title'        => 'Umelá inteligencia v klinickej praxi: stratégia začína problémom, nie technológiou',
    'slug'         => 'ai-klinicka-prax-strategia-zacina-problemom',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Najprv pomenujte klinický alebo organizačný problém, až potom zvažujte umelú inteligenciu. Čo o ambientnej dokumentácii ukázala randomizovaná skúška a čo znamená riadenie počas celého životného cyklu.',
    'content'      => <<<'HTML'
<figure><a href="img/ai-klinicka-prax-strategia-zacina-problemom.webp" rel="noopener noreferrer" target="_blank"><img src="img/ai-klinicka-prax-strategia-zacina-problemom.webp" alt="Chaotické dátové vlákna prechádzajú svetelnou mriežkou a vychádzajú ako jediný jantárový lúč k polopriesvitnej obličke" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna, nejde o snímku konkrétneho pacienta ani výrobku. Užitočná umelá inteligencia nie je tá, ktorá vie „niečo“, ale tá, ktorá cez jasný filter problému dorazí k rozhodnutiu o pacientovi.</figcaption></figure>

<p>Umelá inteligencia (AI) sa v zdravotníctve rýchlo presúva z výskumných prostredí do bežnej klinickej praxe. Otázka už nie je, či dokáže „niečo“. Dôležité sú tri prepojené otázky: <strong>rieši konkrétny klinický alebo organizačný problém, dá sa bezpečne začleniť do pracovného postupu a dá sa riadiť počas celého životného cyklu?</strong></p>

<p>Tento text zhŕňa hlavné princípy klinického zavádzania AI. Vychádza z odborného rozhovoru Digital Health Pulse na portáli Medscape (Abulata, Pandita)<sup>5</sup> a dopĺňa ho o overiteľné rámce etiky a riadenia AI, regulačný pohľad FDA a klinické dôkazy, najmä randomizovanú skúšku ambientnej dokumentácie.<sup>1,2,4</sup></p>

<h2>1. AI nie je stratégia, je to prostriedok</h2>

<p>V zdravotníckych organizáciách často vzniká pokušenie nasadiť AI ako „novú iniciatívu“. V praxi však zlyháva vtedy, keď je cieľ definovaný opačne: najprv sa vyberie technológia a až potom sa hľadá problém, ktorý by „mohla“ zlepšiť.</p>

<p>Deepti Pandita, hlavná lekárska informatička a riaditeľka pre AI na University of California Irvine Health, to formuluje priamo: <em>„AI nie je stratégia. AI môže byť prostriedkom, ktorý existujúce stratégie posilní.“</em> Kľúčový manažérsky princíp je preto tento: <strong>začať formuláciou problému a až potom určiť, či je AI vhodný nástroj.</strong> Tak sa znižuje riziko, že organizácia zavedie riešenie, ktoré nezodpovedá skutočným bariéram v starostlivosti, procesoch alebo zodpovednostiach.<sup>5</sup></p>

<p>Tento prístup je v súlade aj s rámcami, ktoré hodnotia AI podľa vplyvu na bezpečnosť, kvalitu, dôveryhodnosť, rovnosť v prístupe a zodpovednosť, nie podľa technologickej zaujímavosti.<sup>1,3</sup></p>

<h2>2. Kritické otázky pred každým nasadením</h2>

<p>Pri hodnotení riešenia s AI by si zdravotnícky líder mal položiť aspoň tieto otázky:</p>

<ol>
  <li><strong>Aký konkrétny problém riešime?</strong> Ide o klinický problém, administratívnu záťaž, kvalitu dokumentácie, dostupnosť starostlivosti, alebo o bezpečnostné riziká?</li>
  <li><strong>Ako presne AI na problém odpovedá?</strong> Nestačí, že model „niečo vie“. Musí byť preukázané, že výstup je relevantný pre rozhodovanie a že zlepší merateľný proces alebo výsledok.</li>
  <li><strong>Kde v pracovnom postupe AI skutočne zapadne?</strong> Aj dobrý model môže zlyhať, ak pridá nové kliknutia, nové obrazovky, nové kontrolné kroky alebo ďalšie upozornenia.</li>
  <li><strong>Aké riziká nesie a ako ich riadime?</strong> Najmä presnosť, skreslenie (bias), transparentnosť, kybernetická bezpečnosť, ochrana osobných údajov a zodpovednosť za chyby.</li>
  <li><strong>Aké je meradlo úspechu?</strong> Úspech nemá znamenať počet nasadených modelov, ale zlepšenie starostlivosti, skúsenosti pacienta a zníženie záťaže klinikov.</li>
</ol>

<p>Práve posledný bod je rozhodujúci. Organizácia môže získať „reportovateľné“ ukazovatele nasadenia a zároveň stratiť reálnu kvalitu, ak sa pracovný postup zhorší.</p>

<h2>3. Pracovný postup, kognitívna záťaž a nenápadná integrácia</h2>

<p>Jedným z najčastejších dôvodov zlyhania nástrojov s AI je zavádzanie bez skutočného návrhu pracovných tokov. Vtedy vzniká efekt „ďalšej vrstvy“: pribudnú prehľady, upozornenia a ďalšie informačné kanály, ktoré klinikom nepomôžu, ale zvýšia komplexnosť a rozptýlia pozornosť.</p>

<p>Praktická zásada, ktorú uvádza rozhovor aj odborné rámce, znie: <strong>AI má znižovať kognitívnu záťaž a vracať čas na priamy klinický kontakt</strong>, nie pridávať administratívnu prácu. Pandita to vyjadruje vetou, že najlepšia AI je tá, ktorú klinik „nikdy nevidí“, lebo je súčasťou prirodzeného postupu bez ďalšieho tlačidla a ďalšej obrazovky.<sup>5</sup></p>

<p>V nefrologickej praxi sa to týka napríklad:</p>

<ul>
  <li>dokumentovania dialyzačnej starostlivosti a výmeny informácií medzi dialyzačnými jednotkami,</li>
  <li>prípravy ošetrovacích plánov pri chronickej chorobe obličiek, akútnom poškodení obličiek a poruchách elektrolytov,</li>
  <li>riadenia prediktívnych upozornení tak, aby boli klinicky relevantné a nepreťažovali tím,</li>
  <li>podpory konzistentnej komunikácie medzi nefrológom, internistom, laboratóriom a sesterským tímom.</li>
</ul>

<h2>4. Ambientná dokumentácia: čo ukázala randomizovaná skúška</h2>

<p>Ambientná dokumentácia (ambientné „scriby“) sľubuje, že zachytí priebeh rozhovoru a vytvorí návrh klinickej poznámky, čím môže skrátiť čas písania a potenciálne znížiť aj vyhorenie. Ide však o <strong>návrhy, ktoré vyžadujú dohľad</strong>, a kvalita môže byť nekonzistentná.</p>

<p>Pragmatická randomizovaná klinická skúška Lukaca a kol. zaradila <strong>238 ambulantných lekárov zo 14 špecializácií</strong> v pomere 1 : 1 : 1 (vyvážená randomizácia podľa času v poznámke, východiskového skóre vyhorenia a počtu ambulantných dní) do troch skupín: Microsoft Dragon Ambient eXperience (DAX) Copilot, Nabla, alebo bežná starostlivosť bez ambientného prepisu. Sledovanie prebiehalo od 4. novembra 2024 do 3. januára 2025.<sup>4</sup></p>

<p><strong>Primárny ukazovateľ</strong> bol čas strávený písaním poznámky (time-in-note). Výsledok:</p>

<ul>
  <li><strong>Nabla:</strong> významné zníženie oproti kontrole o <strong>9,5 %</strong> (95 % interval spoľahlivosti −17,2 % až −1,8 %; P = 0,02),</li>
  <li><strong>DAX:</strong> bez významného rozdielu oproti kontrole, <strong>−1,7 %</strong> (95 % interval spoľahlivosti −9,4 % až +5,9 %; P = 0,66).</li>
</ul>

<p>DAX sa použil v 33,5 % z 24&nbsp;696 návštev, Nabla v 29,5 % z 23&nbsp;653 návštev. <strong>Sekundárne ukazovatele</strong> (Mini-Z 2.0, záťaž úlohami lekára, index profesionálneho naplnenia – pracovné vyčerpanie) naznačili možné zlepšenie pri oboch nástrojoch, no autori zdôrazňujú potrebu potvrdenia vo väčších multicentrických skúškach. Klinicky významné nepresnosti sa podľa hodnotení klinikov vyskytovali „občas“ v oboch nástrojoch; hlásená bola jedna mierna nežiaduca udalosť (stupeň 1). Preto je nutná priebežná opatrnosť a dohľad klinika.<sup>4</sup></p>

<p>Čo z toho plynie prakticky:</p>

<ul>
  <li>ambientná AI môže znížiť dokumentačnú záťaž, no nie je zaručené, že každý produkt prinesie rovnaký účinok,</li>
  <li>aj pri zlepšení pracovného postupu treba počítať s nekonzistenciou výstupu,</li>
  <li>úspech závisí aj od integrácie do elektronickej zdravotnej dokumentácie, od skutočnej miery použitia a od spôsobu validácie a monitorovania.</li>
</ul>

<p>Ak je cieľom „automatizovať administratívu“, merania majú zachytiť vplyv na čas v dokumentácii, kognitívnu záťaž, bezpečnostné signály (nepresnosti, vynechania) aj skúsenosť pacienta počas návštevy.</p>

<h2>5. Riadenie AI počas celého životného cyklu</h2>

<p>AI nie je softvér, ktorý sa raz nainštaluje. Správanie modelov sa môže meniť v čase, napríklad vplyvom zmeny populácie pacientov, zmeny vstupných údajov (aj štýlu dokumentácie), verzií modelov a systémových komponentov, alebo driftu výkonu a rizík.</p>

<p>Preto nestačí jednorazové schválenie. Rámce WHO zdôrazňujú, že etika a riadenie AI pre zdravie majú byť v centre návrhu, nasadenia aj používania a majú vytvárať mechanizmy zodpovednosti všetkých zainteresovaných strán.<sup>1</sup></p>

<p>Z praktického pohľadu to typicky znamená:</p>

<ul>
  <li><strong>bezpečnostné mantinely</strong> pri spracovaní údajov (ochrana osobných údajov, kontrola úniku),</li>
  <li><strong>viacstranný riadiaci tím</strong> (klinici, informatici, bezpečnosť, právnici, kvalita),</li>
  <li><strong>monitorovanie po nasadení</strong>, vrátane dohľadu nad presnosťou a skreslením,</li>
  <li><strong>plán pre incidenty a sentinelové udalosti</strong>.</li>
</ul>

<h2>6. „Človek v slučke“ nie je len fráza</h2>

<p>V rozhovore zaznieva, že „human in the loop“ (človek v slučke) môže zlyhať, ak klinik skutočne nevie, že rozhodnutie alebo výstup pochádza z AI, nemá čas ani proces na overenie, alebo je zahltený ďalšími krokmi.<sup>5</sup></p>

<p>Pre klinickú zodpovednosť je preto podstatné:</p>

<ul>
  <li>AI má znižovať pracovnú záťaž, nie ju presúvať do slepej kontroly,</li>
  <li>klinik musí mať dostupné mechanizmy, aby mohol overiť relevantné časti výstupu,</li>
  <li>transparentnosť pre používateľa má podporovať dohľad, nie byť administratívnou formalitou.</li>
</ul>

<h2>7. Regulácia a celkový životný cyklus výrobku</h2>

<p>Regulačný pohľad je dôležitý, lebo nástroje s AI môžu zasahovať do diagnostiky, rozhodovania a dokumentácie. Americký Úrad pre kontrolu potravín a liečiv (FDA) zdôrazňuje základnú tézu: <strong>FDA nereguluje AI ako takú, reguluje zdravotnícke pomôcky</strong>, vrátane pomôcok s AI, podľa rizika a určeného účelu. Zároveň sleduje pomôcky naprieč celkovým životným cyklom výrobku (total product lifecycle): od vývoja a validácie cez nasadenie, monitorovanie, údržbu až po úpravy.<sup>2</sup></p>

<p>Pre zdravotnícke organizácie z toho vyplýva, že aj keď klinické tímy nie sú priamo tvorcami výrobkov, potrebujú procesy na:</p>

<ul>
  <li>vyžiadanie relevantnej dokumentácie k bezpečnosti a výkonnosti,</li>
  <li>definovanie, kto je zodpovedný za monitorovanie,</li>
  <li>nastavenie pravidiel pre zmeny a verzie,</li>
  <li>školenie používateľov a auditovanie použitia.</li>
</ul>

<h2>8. Ako merať úspech a kde byť opatrný</h2>

<p>V praxi sa ukazuje, že úspech je dvojitý:</p>

<ol>
  <li><strong>pacient dostane lepšiu starostlivosť, alebo aspoň rovnakú starostlivosť bezpečnejšie a konzistentnejšie,</strong></li>
  <li><strong>klinici získajú čas a znižuje sa administratívna záťaž bez zhoršenia bezpečnosti.</strong></li>
</ol>

<p>Opatrnosť má byť najmä tam, kde jednopercentná chyba môže mať vysokú cenu, kde AI vstupuje priamo do klinických rozhodnutí bez primeraného dohľadu, alebo kde je nejasná verifikácia výstupu a monitorovanie incidentov. V administratíve môže byť tempo zavádzania rýchlejšie, no aj tam treba mať realistické očakávania, merania a bezpečnostné brzdy.<sup>5</sup></p>

<h2>9. Odporúčania pre nefrologické pracoviská</h2>

<p>Ak nefrologické oddelenie zvažuje riešenie s AI, postavte projekt ako pilot s jasnými kritériami:</p>

<ul>
  <li><strong>Vyberajte problém, nie dodávateľa.</strong> Začnite dokumentačnou záťažou, kvalitou záznamov, konzistentnosťou plánov alebo dostupnosťou.</li>
  <li><strong>Definujte pracovný postup a merania vplyvu vopred.</strong> Čas, kognitívna záťaž, bezpečnostné signály, kvalita výstupu, akceptácia tímom.</li>
  <li><strong>Počítajte s dohľadom a validáciou.</strong> Aj keď AI zrýchľuje, potrebuje proces pre nepresnosti, vynechania a audit kvality.</li>
  <li><strong>Zaveďte riadenie počas celého životného cyklu.</strong> Monitorovanie driftu, verzií, incidentov a skreslenia.</li>
  <li><strong>Školte tím realisticky.</strong> Nie iba „ako zapnúť nástroj“, ale ako interpretovať návrhy AI a kedy sa na ne nespoliehať.</li>
</ul>

<h2>Limity</h2>

<ul>
  <li><strong>Východiskový zdroj je odborný rozhovor</strong>, teda názor skúsených odborníkov, nie systematický prehľad. Tvrdenia o účinku ambientnej dokumentácie sú tu podložené samostatnou randomizovanou skúškou; tam, kde ide o interpretačný rámec, je to uvedené.</li>
  <li><strong>Randomizovaná skúška ambientných nástrojov</strong> trvala približne dva mesiace na jednom systéme, so strednou mierou použitia nástrojov v návštevách. Sekundárne ukazovatele vyhorenia a záťaže vyžadujú potvrdenie vo väčších multicentrických skúškach.</li>
  <li><strong>Nefrologicky špecifické dôkazy chýbajú.</strong> Prenos na dialyzačnú dokumentáciu, plány pri chronickej chorobe obličiek alebo prediktívne upozornenia je úvahou o použiteľnosti rámca, nie doloženým nefrologickým výsledkom.</li>
  <li><strong>Regulačný pohľad FDA</strong> sa týka najmä kontextu USA; pre slovenské pracovisko ostáva záväzný európsky rámec zdravotníckych pomôcok a aktu o umelej inteligencii, ktorý je podrobnejšie spracovaný v súvisiacich textoch portálu.</li>
</ul>

<hr>

<p><em>Text je určený zdravotníckym pracovníkom. Nenahrádza právne poradenstvo ani posúdenie súladu konkrétneho produktu. Zodpovednosť za rozhodnutie o pacientovi zostáva na ošetrujúcom lekárovi aj vtedy, keď sa opiera o výstup systému umelej inteligencie.</em></p>

<h2>Literatúra</h2>

<ol>
  <li>World Health Organization. <em>Ethics and governance of artificial intelligence for health: WHO guidance.</em> Ženeva: WHO; 2021. ISBN 978-92-4-002920-0. <a href="https://www.who.int/publications/i/item/9789240029200" target="_blank" rel="noopener noreferrer">who.int</a>.</li>
  <li>U.S. Food and Drug Administration. <em>Artificial Intelligence-Enabled Medical Devices.</em> Aktualizovaná stránka Digital Health Center of Excellence. <a href="https://www.fda.gov/medical-devices/digital-health-center-excellence/artificial-intelligence-enabled-medical-devices" target="_blank" rel="noopener noreferrer">fda.gov</a>.</li>
  <li>Matheny M, Thadaney Israni S, Whicher D, Ahmed M, editors. <em>Artificial Intelligence in Health Care: The Hope, the Hype, the Promise, the Peril.</em> Washington (DC): National Academy of Medicine; 2022. <a href="https://nam.edu/wp-content/uploads/2019/12/AI-in-Health-Care-PREPUB-FINAL.pdf" target="_blank" rel="noopener noreferrer">nam.edu (PDF)</a>.</li>
  <li>Lukac PJ, Turner W, Vangala S, Chin AT, Khalili J, Shih YCT, Sarkisian C, Cheng EM, Mafi JN. Ambient AI Scribes in Clinical Practice: A Randomized Trial. <em>NEJM AI.</em> 2025;2(12). doi: <a href="https://doi.org/10.1056/aioa2501000" target="_blank" rel="noopener noreferrer">10.1056/aioa2501000</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/41497288/" target="_blank" rel="noopener noreferrer">41497288</a>, PMC: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12768499/" target="_blank" rel="noopener noreferrer">PMC12768499</a>. ClinicalTrials.gov: NCT06792890.</li>
  <li>Abulata N, Pandita D. AI Isn't the Strategy. Knowing Where to Use It Is. <em>Medscape – Global Digital Health Pulse</em>, 16. októbra 2026. <a href="https://www.medscape.com/viewarticle/ai-isnt-strategy-knowing-where-use-it-2026a10012s6" target="_blank" rel="noopener noreferrer">medscape.com</a>.</li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p>Rozhovor na Medscape (citácia 5) bol 1. novembra 2026 prečítaný v celom rozsahu vrátane byline a dátumu. Úplný autorský zoznam, DOI, PMID, PMCID, ročník a číslo skúšky Lukaca a kol. (citácia 4) boli overené cez PubMed, Crossref a PMC ID Converter; čísla time-in-note, intervaly spoľahlivosti, miery použitia a hodnotenie nepresností pochádzajú zo štruktúrovaného abstraktu. Téza FDA, že úrad nereguluje AI ako takú, ale zdravotnícke pomôcky, bola overená na stránke FDA. Publikácia WHO (2021) a správa National Academy of Medicine boli overené podľa verejne dostupných bibliografických údajov. Predloha správne uviedla hlavné čísla RCT; doplnené boli miera použitia nástrojov, identifikátory NCT/PMID/PMC, upozornenie na limity sekundárnych ukazovateľov a oddelenie názoru z rozhovoru od primárnych dôkazov. Slovenská redakcia odstránila anglicizmy typu seamless/vendor/stakeholder a nahradila ich ustálenými odbornými ekvivalentmi.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=ai-governance-klinicka-prax-nefrologia">UI v klinickej praxi: správa, pracovné postupy a ľudský dohľad</a></li>
  <li><a href="article.php?slug=regulacia-medicinskej-umelej-inteligencie-fda-nefrologia">Regulácia medicínskej umelej inteligencie: čo by mal lekár vedieť</a></li>
  <li><a href="article.php?slug=administrativna-zataz-lekarov-dokumentacia-vyhorenie">Administratívna a dokumentačná záťaž lekára</a></li>
  <li><a href="article.php?slug=umela-inteligencia-nefrologia-co-vieme-limity">Umelá inteligencia v nefrológii: čo vieme a kde sú limity</a></li>
  <li><a href="article.php?slug=ai-scribe-pravne-nastrahy-ambulancia-nefrologia">AI scribe v ambulancii: právne nástrahy</a></li>
  <li><a href="article.php?slug=ai-nefrologia-hands-on-primer-klinicka-integracia">Umelá inteligencia v nefrológii: praktický úvod ku klinickej integrácii</a></li>
</ul>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ai_klinicka_prax_strategia_zacina_problemom',
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
