<?php
/**
 * add_nizkoenergeticka-dieta-cvicenie-remisia-dm2-reset_article.php
 * Odborný článok o štúdii RESET for Remission (nízkoenergetická diéta a štruktúrované
 * cvičenie pri skorom DM2) a jej nefrologických súvislostiach.
 * Spracovanie správy Medscape z EASD 2026 (Nancy A. Melville) a primárnej publikácie.
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Nízkoenergetická diéta a štruktúrované cvičenie pri skorom diabete 2. typu: čo prináša RESET for Remission',
    'slug'         => 'nizkoenergeticka-dieta-cvicenie-remisia-dm2-reset',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Remisia u 54 % oproti 4 % za 24 týždňov, s úbytkom tuku a zachovaním svalu. Čo z toho platí pre nefrológiu, keď štúdia vylučovala filtráciu pod 60 ml/min/1,73 m².',
    'content'      => <<<'HTML'
<figure><a href="img/nizkoenergeticka-dieta-cvicenie-remisia-dm2-reset.webp" rel="noopener noreferrer" target="_blank"><img src="img/nizkoenergeticka-dieta-cvicenie-remisia-dm2-reset.webp" alt="Jantárová masa tukového tkaniva sa vľavo rozpadá na častice, zatiaľ čo napravo zostáva neporušený zväzok svalových vlákien a v pozadí polopriesvitná sklená oblička" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna, nie snímka konkrétneho pacienta ani zobrazenie konkrétneho produktu. Podstatou výsledku štúdie RESET for Remission nie je samotný úbytok hmotnosti, ale to, z ktorého kompartmentu zmizol – a čo zostalo zachované.</figcaption></figure>

<p>Nízkoenergetické diéty dokážu navodiť remisiu diabetu 2. typu (DM2) – to vieme od štúdií DiRECT a DIADEM-I. Čo sa doteraz netestovalo, je ich kombinácia so štruktúrovaným cvičením pod dohľadom, a to u pacientov so <strong>skorým DM2</strong>, teda s diagnózou vo veku do 45 rokov. Táto skupina má agresívnejší priebeh, vyššie celoživotné riziko komplikácií a najviac rokov pred sebou, počas ktorých sa toto riziko realizuje.</p>

<p>Štúdia RESET for Remission, prezentovaná na výročnom kongrese EASD 2026 a súčasne publikovaná v časopise <em>The Lancet Regional Health – Americas</em>, priniesla mieru remisie, ktorá presahuje predchádzajúce práce. Text zhŕňa, čo štúdia ukázala, kde sú jej hranice, a čo z nej – aj z toho, čo v nej nebolo – vyplýva pre nefrológiu.</p>

<h2>Dizajn a populácia</h2>

<p>Išlo o randomizovanú, otvorenú štúdiu účinnosti so zaslepeným hodnotením ukazovateľov (dizajn PROBE), vykonanú v <strong>troch centrách v Anglicku a Kanade</strong>. Randomizácia prebehla v pomere 1:1 s nezávisle generovanou webovou sekvenciou, stratifikovaná podľa krajiny a pohlavia, s premenlivou veľkosťou blokov. Zaradených bolo <strong>96 účastníkov</strong> medzi 24. septembrom 2021 a 6. júnom 2025; záverečné hodnotenie absolvovalo 86 (90 %). Registrácia: ISRCTN15487120.</p>

<div class="table-responsive" role="region" aria-label="Kritériá zaradenia a vylúčenia v štúdii RESET for Remission" tabindex="0">
<table>
<caption>Vybrané kritériá podľa publikovaného protokolu štúdie.</caption>
<thead>
<tr><th scope="col">Kritérium</th><th scope="col">Hodnota</th></tr>
</thead>
<tbody>
<tr><th scope="row">Vek</th><td>18–45 rokov vrátane</td></tr>
<tr><th scope="row">Trvanie diabetu</th><td>viac než 3 mesiace a menej než 6 rokov od diagnózy</td></tr>
<tr><th scope="row">Index telesnej hmotnosti</th><td>30–45 kg/m² pri bielom alebo pôvodnom obyvateľstve; 27–45 kg/m² pri ostatných vrátane zmiešaného pôvodu</td></tr>
<tr><th scope="row">HbA1c</th><td>6,5–10 % bez liečby znižujúcej glykémiu; 6–10 % pri liečbe</td></tr>
<tr><th scope="row">Vylúčenie – obličky</th><td><strong>odhadovaná glomerulová filtrácia pod 60 ml/min/1,73 m²</strong></td></tr>
<tr><th scope="row">Ďalšie vylúčenia</th><td>liečba inzulínom, aktívna malignita, klinicky manifestné cievne ochorenie, srdcové zlyhávanie</td></tr>
</tbody>
</table>
</div>

<p>Vstupná charakteristika: priemerný vek 38 rokov, priemerný index telesnej hmotnosti 35,2 kg/m², 47 % žien, priemerné trvanie diabetu <strong>2,3 roka</strong>, priemerný HbA1c 7,2 %, viac než tri štvrtiny účastníkov užívali lieky znižujúce glykémiu. Súbor bol etnicky zmiešaný – v intervenčnej skupine 18 osôb európskeho, 17 juhoázijského a 15 iného pôvodu.</p>

<h2>Intervencia</h2>

<p><strong>Diéta.</strong> V týždňoch 1–12 nízkoenergetický režim <strong>800–900 kcal denne</strong> so zložením 30 % bielkoviny, 50 % sacharidy, 20 % tuky. Prvé dva týždne tvorili úplné náhrady jedál; od tretieho týždňa bol režim pestrejší a dovoľoval jedno bežné jedlo denne pri zachovaní energetického limitu. Odporúčaný bol príjem aspoň dvoch litrov nekalorických tekutín denne a vláknina ako laxatívum podľa potreby. V týždňoch 13–24 nasledovala udržiavacia diéta.</p>

<p><strong>Cvičenie.</strong> Dvakrát týždenne cvičenie pod dohľadom a raz týždenne samostatné, pričom cvičebná zložka sa pripojila od tretieho týždňa a postupne narástla na hodinu na jednotku s rovnakým podielom aeróbneho a silového tréningu. Aeróbnu časť tvorila najmä chôdza a vysokointenzívny intervalový tréning pri dobrej tolerancii, silovú stroje alebo voľné váhy. V dňoch s cvičením sa pridávala náhrada jedla navyše s obsahom 200–250 kcal. V týždňoch 13–24 pokračovalo samostatné cvičenie.</p>

<p><strong>Lieky.</strong> Všetky lieky znižujúce glykémiu aj krvný tlak boli na začiatku vysadené – antihypertenzíva <em>v neprítomnosti albuminúrie</em>, s možnosťou opätovného nasadenia pri klinickej indikácii. Kontrolná skupina dostávala obvyklú starostlivosť.</p>

<h2>Výsledky</h2>

<h3>Primárny ukazovateľ</h3>

<p>Remisia v 24. týždni bola definovaná ako HbA1c pod 6,5 % (48 mmol/mol) bez liekov znižujúcich glykémiu počas predchádzajúcich aspoň 12 týždňov. Analýza zahrnula všetkých randomizovaných, pričom chýbajúci údaj sa počítal ako absencia remisie – teda konzervatívne.</p>

<p>Remisiu dosiahlo <strong>27 z 50 (54 %)</strong> účastníkov v intervenčnej skupine oproti <strong>2 zo 46 (4 %)</strong> v kontrolnej; absolútny rozdiel 50 percentuálnych bodov (95 % IS 33–64), upravený pomer šancí <strong>21,6 (95 % IS 6,2–114,5)</strong>. Výsledok bol konzistentný v podskupinách podľa pohlavia, etnicity aj krajiny.</p>

<p>Široký interval spoľahlivosti pomeru šancí je dôsledkom toho, že v kontrolnej skupine nastali len dve udalosti; absolútny rozdiel je preto spoľahlivejším vyjadrením veľkosti účinku než samotný pomer šancí.</p>

<h3>Zloženie tela – podstata nálezu</h3>

<p>Toto je miesto, kde sa štúdia líši od predchádzajúcich. Intervenčná skupina schudla o 7,0 % viac než kontrolná a aspoň päťpercentný úbytok dosiahla viac než polovica (56 %) jej účastníkov. Úbytok však nebol rovnomerný:</p>

<ul>
  <li>tuková hmota meraná dvojenergiovou röntgenovou absorpciometriou klesla o 16,5 % viac než v kontrolnej skupine;</li>
  <li><strong>v beztukovej hmote ani v objeme svalu meranom magnetickou rezonanciou sa skupiny významne nelíšili</strong>;</li>
  <li>v prieskumnej analýze nebol zistený úbytok objemu brušného a stehnového svalstva a bola pozorovaná podstatne menšia tuková infiltrácia svalu;</li>
  <li>sila stisku ruky sa zvýšila.</li>
</ul>

<p>Autori upozorňujú, že žiadna predchádzajúca štúdia remisie nekombinovala štruktúrované cvičenie pod dohľadom s nízkoenergetickou diétou ani nepoužila magnetickú rezonanciu na kvantifikáciu objemu svalu a vnútrosvalového tuku. To je dôvod, prečo je výsledok zaujímavý aj mimo diabetológie: ukazuje, že hlboký kalorický deficit nemusí znamenať stratu svalovej hmoty, ak ho sprevádza silový tréning.</p>

<h3>Ostatné ukazovatele</h3>

<ul>
  <li>HbA1c klesol o 0,7 percentuálneho bodu viac než v kontrolnej skupine; zlepšila sa inzulínová rezistencia hodnotená modelom HOMA-IR.</li>
  <li>Kardiorespiračná zdatnosť vztiahnutá na telesnú hmotnosť sa v 24. týždni zlepšila o 10,3 %.</li>
  <li>Počet krokov a čas strednej až vysokej pohybovej aktivity sa zlepšili výraznejšie v 12. týždni, pričom do 24. týždňa sa rozdiel zmenšil.</li>
  <li>Absolútna frakcia tuku v pečeni klesla o 9,1 % a v pankrease o 1,3 %.</li>
  <li>Zlepšil sa krvný tlak, pokojová srdcová frekvencia a triacylglyceroly.</li>
  <li>Znížili sa depresívne príznaky aj záťaž spojená s diabetom; zlepšil sa index vlastného hodnotenia zdravia EuroQol-5D.</li>
</ul>

<h3>Remisia hypertenzie – s dôležitou výhradou</h3>

<p>Remisia hypertenzie nastala v <strong>12. týždni u 63 % intervenčnej a 13 % kontrolnej skupiny</strong> (upravený pomer šancí 8,9). V 24. týždni sa však rozdiel zúžil na <strong>56 % verzus 27 %</strong>.</p>

<p>Toto zúženie je potrebné uviesť – a sekundárne zhrnutia ho spravidla vynechávajú. Ukazuje, že najvýraznejší tlakový efekt sa viaže na obdobie najhlbšieho kalorického deficitu, a po prechode na udržiavací režim časť účinku ustupuje. Pre nefrológiu, kde je kontrola tlaku kľúčovým nástrojom spomalenia progresie, je rozdiel medzi prechodným a trvalým účinkom zásadný.</p>

<h3>Bezpečnosť</h3>

<p>Závažné nežiaduce udalosti sa nevyskytli. Aspoň jednu nežiaducu udalosť však malo <strong>43 z 50</strong> účastníkov intervenčnej skupiny oproti 6 zo 46 v kontrolnej – prevažne skoré prejavy nízkoenergetickej diéty (zápcha, bolesť hlavy, závraty, únava) a muskuloskeletálne ťažkosti či poranenia súvisiace s tréningom; väčšina odznela.</p>

<h2>Čo z toho vyplýva pre nefrológiu</h2>

<p>Tu je nutné byť opatrný, pretože štúdia nebola nefrologická a pokušenie nadinterpretovať je veľké.</p>

<ol>
  <li><strong>Populácia bola renálne zdravá podľa návrhu.</strong> Vylučovacím kritériom bola glomerulová filtrácia pod 60 ml/min/1,73 m², takže nikto s CKD štádia 3 a vyššieho zaradený nebol. Výsledky nemožno prenášať na pacientov s pokročilou chorobou obličiek, a už vôbec nie na dialyzovaných, u ktorých by režim 800–900 kcal denne vyžadoval úplne inú úvahu o bielkovinách, kaliu a fosfátoch.</li>
  <li><strong>Obličkové ukazovatele nie sú v dostupnom abstrakte ani v kongresovej správe uvedené.</strong> Dvadsaťštyri týždňov je príliš krátke obdobie na spoľahlivé posúdenie dlhodobej renálnej prognózy. Sklon eGFR je zástupný ukazovateľ; klinickým výsledkom je napríklad zlyhanie obličiek. Absencia rozdielu by preto neznamenala absenciu renálneho prínosu – a ani naopak.</li>
  <li><strong>Vysadenie antihypertenzív „v neprítomnosti albuminúrie“ je protokolový krok, nie odporúčanie do praxe.</strong> Prebiehal pod intenzívnym dohľadom s možnosťou opätovného nasadenia. Mimo štúdie platí, že albuminúria je indikáciou pre inhibítor ACE alebo sartan nezávisle od hodnoty tlaku a jeho vysadenie pri úbytku hmotnosti nie je samozrejmé.</li>
  <li><strong>Mechanizmus je však renálne relevantný.</strong> Mladý pacient so skorým DM2 je presne ten, u koho sa diabetická choroba obličiek za desaťročia rozvinie. Každý rok strávený v normoglykémii bez liekov znižuje kumulatívnu záťaž hyperglykémiou. To je epidemiologická úvaha, nie doložený výsledok – ale je to úvaha, ktorá dáva skorej intervencii zmysel.</li>
  <li><strong>Zachovanie svalovej hmoty je samostatne cenné.</strong> Sarkopénia a myosteatóza sú pri chronickej chorobe obličiek silnými prognostickými ukazovateľmi. Ak sa dá hmotnosť znižovať bez straty svalu, je to pre neskoršiu nefrologickú trajektóriu pacienta priaznivejšie než rovnaký úbytok dosiahnutý samotnou reštrikciou – a je to argument, ktorý sa prenáša aj do diskusie o liečbe agonistami receptora GLP-1.</li>
  <li><strong>Nefarmakologická možnosť má svoje miesto.</strong> Autori ju stavajú ako výrazne lacnejšiu alternatívu k metabolickej chirurgii a k dlhodobej farmakoterapii, ktorá u mladých pacientov – najmä u žien plánujúcich tehotenstvo – prináša otázky, na ktoré zatiaľ nemáme odpoveď. Ako hlavná autorka Kaberi Dasgupta uviedla, časť pacientov jednoducho chce nefarmakologickú možnosť.</li>
</ol>

<h2>Limity</h2>

<ul>
  <li><strong>Chýba rameno so samotnou diétou.</strong> Štúdia neumožňuje oddeliť, koľko z účinku pridalo štruktúrované cvičenie nad rámec nízkoenergetickej diéty. Vzhľadom na to, že miery remisie po samotnej diéte v predchádzajúcich štúdiách boli tiež vysoké, je prídavný prínos cvičenia pre remisiu nedokázaný – pravdepodobne však spočíva inde, v zachovaní svalu a zlepšení zdatnosti.</li>
  <li><strong>Krátke sledovanie.</strong> Dvadsaťštyri týždňov nehovorí nič o tom, aká časť pacientov zostane v remisii po roku alebo po piatich rokoch. Práve dlhodobá udržateľnosť je pri tomto type intervencie najväčšou neznámou.</li>
  <li><strong>Malá vzorka.</strong> Deväťdesiatšesť randomizovaných, dve udalosti v kontrolnej skupine – odtiaľ aj veľmi široký interval spoľahlivosti pomeru šancí.</li>
  <li><strong>Vysoká náročnosť intervencie.</strong> Dohľadované cvičenie dvakrát týždenne, koučovanie lekármi a dietológmi, náhrady jedál – organizačne a finančne náročné. Prenos do bežnej ambulantnej praxe je samostatný problém, ktorý štúdia nerieši.</li>
  <li><strong>Otvorený dizajn.</strong> Zaslepené bolo len hodnotenie ukazovateľov; očakávania účastníkov mohli ovplyvniť správanie aj ukazovatele kvality života.</li>
  <li><strong>Prísna selekcia.</strong> Vek do 45 rokov, trvanie diabetu pod 6 rokov, bez inzulínu, bez cievneho ochorenia, bez CKD štádia 3 – teda najpriaznivejšia možná populácia. Čím dlhšie diabetes trvá, tým je remisia menej pravdepodobná.</li>
</ul>

<hr>

<p><em>Text je určený zdravotníckym pracovníkom. Nenahrádza odborné posúdenie konkrétneho prípadu. Nízkoenergetický režim 800–900 kcal denne patrí pod lekársky a dietologický dohľad; u pacientov s chronickou chorobou obličiek, s liečbou inzulínom alebo derivátmi sulfonylurey a u tehotných alebo dojčiacich žien je bez úpravy nevhodný. Vysadenie antihypertenzív alebo antidiabetík je rozhodnutím ošetrujúceho lekára.</em></p>

<h2>Literatúra</h2>

<ol>
  <li>Dasgupta K, Boulé NG, Henson J, Redman E, Chan D, McCarthy M, et al. Low energy diet plus supervised exercise vs. usual care alone in people with early-onset type 2 diabetes (RESET for Remission): a randomised, open-label, blinded-endpoint efficacy trial. <em>Lancet Reg Health Am.</em> 2026;101664. doi: <a href="https://doi.org/10.1016/j.lana.2026.101664" target="_blank" rel="noopener noreferrer">10.1016/j.lana.2026.101664</a>. ISRCTN15487120.</li>
  <li>Dasgupta K, Boulé N, Henson J, Chevalier S, Redman E, Chan D, et al. Remission of type 2 diabetes and improved diastolic function by combining structured exercise with meal replacement and food reintroduction among young adults: the RESET for REMISSION randomised controlled trial protocol. <em>BMJ Open.</em> 2022;12(9):e063888. doi: <a href="https://doi.org/10.1136/bmjopen-2022-063888" target="_blank" rel="noopener noreferrer">10.1136/bmjopen-2022-063888</a>. PMID: 36130753, PMC9494595.</li>
  <li>Melville NA. Low-Calorie Diet/Exercise Intervention May Drive Diabetes Into Remission. <em>Medscape Medical News</em> – EASD 2026, 13. októbra 2026. <a href="https://www.medscape.com/viewarticle/low-calorie-diet-exercise-intervention-may-drive-diabetes-2026a10012cw" target="_blank" rel="noopener noreferrer">medscape.com</a>.</li>
  <li>Lean MEJ, Leslie WS, Barnes AC, et al. Primary care-led weight management for remission of type 2 diabetes (DiRECT): an open-label, cluster-randomised trial. <em>Lancet.</em> 2018;391(10120):541–551. doi: <a href="https://doi.org/10.1016/S0140-6736(17)33102-1" target="_blank" rel="noopener noreferrer">10.1016/S0140-6736(17)33102-1</a>.</li>
  <li>Taheri S, Zaghloul H, Chagoury O, et al. Effect of intensive lifestyle intervention on bodyweight and glycaemia in early type 2 diabetes (DIADEM-I): an open-label, parallel-group, randomised controlled trial. <em>Lancet Diabetes Endocrinol.</em> 2020;8(6):477–489. doi: <a href="https://doi.org/10.1016/S2213-8587(20)30117-0" target="_blank" rel="noopener noreferrer">10.1016/S2213-8587(20)30117-0</a>.</li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p>Údaje o dizajne, populácii a primárnom ukazovateli pochádzajú zo štruktúrovaného abstraktu primárnej publikácie; kritériá zaradenia a vylúčenia vrátane renálneho z publikovaného protokolu (citácia 2); sekundárne a prieskumné ukazovatele z kongresovej správy z EASD 2026 (citácia 3). Bibliografické údaje boli overené cez Crossref, PubMed a Europe PMC k 17. októbru 2026. Plné znenie primárnej publikácie nebolo pri príprave tohto textu prístupné, preto sú sekundárne ukazovatele uvedené v rozsahu, v akom ich uvádza kongresová správa, a obličkové ukazovatele nie sú uvedené vôbec – namiesto toho, aby boli odhadnuté.</p>

<p>Oproti bežným zhrnutiam tejto štúdie sú tu opravené alebo doplnené tieto veci. Práca <strong>nevyšla v časopise <em>The Lancet</em></strong>, ale v <em>The Lancet Regional Health – Americas</em>; zámena je rozšírená a mení váhu, ktorú čitateľ práci pripíše. Doplnená je presná veľkosť účinku vrátane absolútneho rozdielu 50 percentuálnych bodov a upraveného pomeru šancí 21,6 (95 % IS 6,2–114,5), spolu s upozornením, že pri dvoch udalostiach v kontrolnej skupine je spoľahlivejším vyjadrením absolútny rozdiel. Doplnené sú konkrétne kritériá vrátane renálneho (filtrácia pod 60 ml/min/1,73 m²), ktoré sú pre nefrologickú interpretáciu rozhodujúce. Uvedené je <strong>zúženie rozdielu v remisii hypertenzie medzi 12. a 24. týždňom</strong> (63 % oproti 13 % verzus 56 % oproti 27 %), ktoré zhrnutia spravidla vynechávajú, hoci práve ono rozlišuje prechodný účinok od trvalého. A napokon je doplnený rozsah nežiaducich udalostí – 43 z 50 účastníkov intervenčnej skupiny malo aspoň jednu – pretože formulácia „neboli závažné nežiaduce udalosti“ sama osebe vytvára nepravdivý dojem o znášanlivosti režimu.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=glp1-era-novy-model-starostlivosti-o-obezitu-nefrologia">Éra GLP-1: nový model starostlivosti o obezitu v nefrológii</a></li>
  <li><a href="article.php?slug=farmakologicka-liecba-obezity-pokrocile-ckd-dialyza">Farmakologická liečba obezity pri pokročilej CKD a na dialýze</a></li>
  <li><a href="article.php?slug=obezita-kardiometabolicke-zdravie-ckd-ckm-ramec">Obezita, kardiometabolické zdravie a CKD v rámci CKM</a></li>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">CKD pri diabete: skríning a vrstvená kardiorenálna liečba</a></li>
  <li><a href="article.php?slug=diabeticka-choroba-obliciek-bez-zahad">Diabetická choroba obličiek bez záhad</a></li>
  <li><a href="article.php?slug=glp1-obezita-vysadenie-dlhodoba-liecba-nefrologicky-pohlad">Vysadenie liečby GLP-1 a dlhodobá liečba obezity: nefrologický pohľad</a></li>
</ul>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci článok
// (regenerácia). Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt), is_top = VALUES(is_top)"
);

foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title'        => $a['title'],
            'slug'         => $a['slug'],
            'author'       => $a['author'],
            'content'      => $a['content'],
            'excerpt'      => $a['excerpt'],
            'published_at' => $a['published_at'],
            'is_top'       => $a['is_top'],
        ]);
        // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho článku, 0 = bez zmeny.
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            // UPDATE: lastInsertId nemusí vrátiť existujúce id → dohľadaj podľa slug.
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            // Newsletter avízo LEN pri novom článku, nikdy pri regenerácii/update.
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_reset_remission_dm2_2026 newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_reset_remission_dm2_2026 pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_reset_remission_dm2_2026 pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_reset_remission_dm2_2026 migration error: ' . $e->getMessage());
    }
}

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
