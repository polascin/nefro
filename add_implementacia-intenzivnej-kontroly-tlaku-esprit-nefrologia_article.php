<?php
/**
 * add_implementacia-intenzivnej-kontroly-tlaku-esprit-nefrologia_article.php
 * Odborný článok (úvodná stránka, kategória 'odborne') — spracovanie zdrojového
 * komentára (Medscape, Zuo & Wang) k post hoc analýze štúdie ESPRIT. Pôvodní
 * autori zdroja sú v source_authors.php (slug → mená).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_implementacia-intenzivnej-kontroly-tlaku-esprit-nefrologia_article.php"
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Implementačné stratégie intenzívnej kontroly krvného tlaku: čo sa môžeme naučiť pre bežnú klinickú prax (so zameraním aj na nefrológiu)',
    'slug'         => 'implementacia-intenzivnej-kontroly-tlaku-esprit-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Post hoc analýza štúdie ESPRIT ukazuje, že systolický cieľ pod 120 mm Hg je dosiahnuteľný aj v primárnej starostlivosti – ak sa implementuje protokolovo. Čo si z toho odniesť pre nefrologickú a internú prax.',
    'content'      => <<<'NEFRO_HTML'
<p class="article-dek"><em>Post hoc analýza štúdie ESPRIT ukazuje, že systolický cieľ pod 120 mm Hg je dosiahnuteľný aj v primárnej starostlivosti – ak sa implementuje štruktúrovane a protokolovo. Kľúčové posolstvo neznie „aké lieky“, ale „ako sa robí proces“.</em></p>

<h2>1. Prečo je téma intenzívnej kontroly tlaku dnes taká aktuálna</h2>
<p>Intenzívna kontrola krvného tlaku (TK) sa v posledných rokoch posúva z roviny „akademickej hypotézy“ do roviny praktickej implementácie. V mnohých medzinárodných aj národných odporúčaniach sa TK používa ako jeden z kľúčových modifikovateľných rizikových faktorov, a preto sa prirodzene mení aj očakávanie smerom k nižším cieľom.</p>
<p>Súčasne však zostáva klasická bariéra: obava z takzvanej J-krivky (riziko pri príliš nízkom TK z dôvodu nedostatočnej perfúzie orgánov, ako sú srdce, mozog a obličky). Článok, z ktorého vychádzam, tento koncept nepopiera, ale poukazuje na praktický kľúč: v ére digitálneho zdravotníctva a podporných rozhodovacích nástrojov by malo byť možné dosahovať čo najoptimálnejšiu kontrolu TK tak, aby sa maximalizoval kardiovaskulárny benefit.</p>
<p>Pre klinika to znamená jediné: nejde iba o „cieľový tlak“, ale najmä o to, <strong>ako</strong> sa k nemu pacient dostane, ako rýchlo sa titruje liečba, ako sa sleduje tolerancia a či sa merania robia konzistentne.</p>

<h2>2. Čo prináša zdrojový materiál: ESPRIT a post hoc analýza</h2>
<p>Zdrojový text je komentár k výsledkom post hoc analýzy štúdie ESPRIT (Effects of Intensive Systolic Blood Pressure Lowering Treatment in Reducing Risk of Vascular Events). Zdôrazňuje sa v ňom, že ESPRIT bola jedinou štúdiou dostatočne dimenzovanou na to, aby <strong>cieľ intenzívneho ramena reálne smeroval k priemernému systolickému TK pod 120 mm Hg</strong>.</p>
<p>Čo je dôležité pre implementáciu:</p>
<ul>
  <li>intenzívne rameno bolo definované cieľom <strong>pod 120 mm Hg</strong> (štandardné rameno pod 140 mm Hg),</li>
  <li>analýza sa zamerala na pacientov s hypertenziou a vysokým kardiovaskulárnym rizikom,</li>
  <li>dôraz sa kládol aj na <strong>dĺžku trvania hypertenzie</strong> a na stav kontroly TK na začiatku.</li>
</ul>

<h3>2.1. Uskutočniteľnosť v praxi</h3>
<p>V intenzívnom ramene (cieľ pod 120 mm Hg) dosiahlo podľa zdroja takúto kontrolu <strong>62,5 % pacientov</strong>. Zároveň to nebolo spojené s „extrémnym“ eskalovaním liečby:</p>
<ul>
  <li>približne <strong>o 1,3 antihypertenzíva viac</strong> oproti štandardnému ramenu,</li>
  <li>a približne <strong>o 1,5 návštevy v ambulancii viac</strong> v horizonte jedného roka.</li>
</ul>
<p>Znie to ako technický detail, no v praxi je to presne to, čo robí implementáciu uveriteľnou. Ak by intenzívna kontrola vyžadovala dramaticky vyššiu záťaž (veľké počty liekov, masívnu frekvenciu návštev bez štandardu), pre bežné pracoviská by bola ťažko škálovateľná.</p>

<h3>2.2. Kto má najväčší problém: pacient s dlhšou anamnézou a nekontrolovaným TK</h3>
<p>Zdroj uvádza, že títo vysokorizikoví pacienti:</p>
<ul>
  <li>boli menej pravdepodobne schopní dosiahnuť <strong>trvalú</strong> intenzívnu kontrolu,</li>
  <li>vyžadovali <strong>dlhší čas</strong> a <strong>viac kontrolných návštev</strong>.</li>
</ul>
<p>Je to veľmi praktické zistenie. Neznamená, že cieľ je nevhodný – iba to, že implementácia musí byť časovo realistická a manažment musí počítať s tým, že niektorí pacienti budú potrebovať viac cyklov titrácie a posilnenie adherencie.</p>

<h2>3. Implementácia nie je len liek, je to systém</h2>
<p>Najväčšia hodnota textu pre nefrológiu a všeobecnú internú prax je posun od otázky „aké lieky“ k otázke „ako sa robí proces“.</p>
<p>Článok opisuje, že ESPRIT bola realizovaná v komunitných zdravotných centrách, ktoré tvoria jadro primárnej starostlivosti. Kľúč však bol v tom, že sa použil <strong>štruktúrovaný, protokolový model starostlivosti</strong>.</p>

<h3>3.1. Tri stavebné kamene implementácie</h3>
<ol>
  <li><strong>Štandardizované protokoly liečby.</strong> Nie „ad hoc“ eskalácia podľa pocitu v ambulancii, ale systematická titrácia podľa pravidiel.</li>
  <li><strong>Podpora meraní a monitorovania.</strong> Zdroj explicitne zdôrazňuje význam centrálne riadeného monitorovania TK.</li>
  <li><strong>Podpora evidence-based farmakoterapie a moderných nástrojov.</strong> Spomína sa, že do budúcnosti bude pribúdať aj využitie technológií vrátane prvkov umelej inteligencie, ktoré môžu zlepšiť konzistentnosť a včasnosť rozhodovania.</li>
</ol>
<p>Pre prax je to formulované veľmi jasne: intenzívna kontrola TK je uskutočniteľná aj v primárnom prostredí, ak existujú správne dávky liekov a organizačný rámec (protokoly, klinické rozhodovacie nástroje, centrálne monitorovanie).</p>

<h2>4. Meranie TK: miesto, kde sa často láme celý cieľ</h2>
<p>Aj keď sa zdroj nepúšťa do dlhého metodického exkurzu, logika implementácie stojí na tom, že bez konzistentných meraní nie je možné robiť „intenzívnu“ kontrolu rozumne.</p>
<p>V praxi to znamená:</p>
<ul>
  <li>jednotný spôsob merania (správna manžeta, pokoj pred meraním, opakované merania),</li>
  <li>kontrolu driftu prístrojov v čase,</li>
  <li>preferovanie meraní, ktoré lepšie odrážajú skutočný TK pacienta (vrátane domácich meraní tam, kde to dáva zmysel).</li>
</ul>
<p>Ak merania nie sú stabilné, titrácia liečby sa mení na hádanie. A práve pri nízkych cieľoch to zvyšuje riziko neprimeranej eskalácie.</p>

<h2>5. J-krivka a bezpečnosť: ako o nej uvažovať klinicky</h2>
<p>Zdroj uvádza, že J-krivka musí teoreticky existovať, ak je TK príliš nízky na perfúziu orgánov. Súčasne však tvrdí, že v praxi musí byť možné dosiahnuť optimálnu kontrolu TK a najnižšie kardiovaskulárne riziko, ak sa proces nastaví správne.</p>
<p>Pre nefrológa je dôležité doplniť praktický rámec:</p>
<ul>
  <li>pri pacientoch s chronickou chorobou obličiek (CKD) sa musí titrácia robiť s dôrazom na toleranciu,</li>
  <li>treba sledovať laboratórne aj klinické ukazovatele (napríklad znaky hypoperfúzie, zhoršenie funkcie obličiek, elektrolytové zmeny podľa použitej liečby),</li>
  <li>a najmä: cieľom nie je „dosiahnuť číslo za každú cenu“, ale „znížiť celkové riziko pri zachovaní bezpečnosti“.</li>
</ul>
<p>Z dostupného úryvku zdroja vyplýva skôr princíp než detailné stopercentné pravidlá. Preto je rozumné chápať to takto: ak sa implementácia robí protokolovo a monitoruje sa tolerancia, priestor pre bezpečné nízke ciele sa zväčšuje.</p>

<h2>6. Klinická logika naprieč veľkými štúdiami</h2>
<p>V texte je popísané, že vo viacerých intenzívne orientovaných štúdiách sa benefit spájal s tým, že riziko v štandardných ramenách bolo vyššie u pacientov s vyšším východiskovým systolickým TK. Súčasne sa v intenzívnych ramenách trendy sledovali tak, že výsledky a veľkosť benefitu sa medzi podskupinami podľa východiskového TK menili.</p>
<p>Čo je pre implementáciu dôležité:</p>
<ul>
  <li>intenzívna stratégia sa nemá chápať ako „jednostranný“ prístup rovnaký pre všetkých,</li>
  <li>ale skôr ako prístup, ktorý sa dá škálovať cez protokolové riadenie a monitorovanie.</li>
</ul>
<p>Článok navyše naznačuje, že J-krivka mohla zohrať úlohu pri rozdieloch v benefite naprieč skupinami podľa východiskového TK.</p>

<h2>7. Praktické implikácie pre nefrologickú a internú ambulanciu</h2>
<p>Nasledujúce nie je „nové usmernenie“, ale praktický preklad toho, čo zdroj zdôrazňuje.</p>

<h3>7.1. Intenzívna kontrola je dosiahnuteľná, ale potrebuje proces</h3>
<p>Ak má ambulancia reálne zlepšovať kontrolu TK, potrebuje:</p>
<ul>
  <li>jasný algoritmus titrácie (kedy zvýšiť dávku, kedy pridať ďalší liek),</li>
  <li>plán kontrol (kedy pacient príde a čo sa pri kontrole vyhodnotí),</li>
  <li>a systém práce s meraniami (aby čísla boli v čase porovnateľné).</li>
</ul>
<p>Zdrojovo relevantné je aj to, že v intenzívnom ramene sa objavuje len „mierne“ zvýšenie intenzity liečby a počtu návštev – no najmä v kontexte protokolového modelu a štruktúrovanej starostlivosti.</p>

<h3>7.2. Riziko pacienta mení nároky na implementáciu</h3>
<p>Zdroj poukazuje, že pacienti s dlhšou anamnézou hypertenzie a s nekontrolovaným TK na začiatku mali horšiu šancu dosiahnuť trvalú intenzívnu kontrolu a potrebovali dlhší čas a viac návštev.</p>
<p>Pre prax to znamená:</p>
<ul>
  <li>nesľubovať „rýchle a lineárne“ zlepšenie každému,</li>
  <li>nastaviť realistické očakávania a pravidelnú iteráciu titrácie,</li>
  <li>a cielene pracovať s adherenciou (tu už prichádzajú aj technológie a podporné nástroje).</li>
</ul>

<h3>7.3. Bezpečnostný rámec pri nižších cieľoch</h3>
<p>Pri intenzívnej kontrole sa bezpečnostný dohľad stáva podstatou stratégie. Pri pacientoch s obličkovým ochorením je to ešte dôležitejšie z dôvodu:</p>
<ul>
  <li>citlivosti na zmeny hemodynamiky,</li>
  <li>rizika nežiaducich účinkov liečby,</li>
  <li>a potreby laboratórnej kontroly.</li>
</ul>
<p>Z textu zdroja vyplýva skôr princíp: optimalizácia rizika je možná, ak sa dosahuje správna kvalita monitorovania a klinické rozhodovanie nie je ponechané iba na náhodu.</p>

<h2>8. Zhrnutie: najdôležitejšie posolstvo</h2>
<p>Článok stojí na myšlienke, že intenzívna kontrola systolického TK (cieľ pod 120 mm Hg) je uskutočniteľná aj v prostredí primárnej starostlivosti, ak sa implementuje štruktúrovane. Kľúčom nie je iba cieľová hodnota, ale:</p>
<ul>
  <li>protokolová titrácia,</li>
  <li>konzistentné monitorovanie,</li>
  <li>podpora klinických rozhodnutí,</li>
  <li>a realistické plánovanie návštev a času do dosiahnutia stabilnej kontroly.</li>
</ul>
<p>Pre nefrológiu je to dôležité, pretože obličky sú citlivé na hemodynamické zmeny a zároveň patria medzi orgány, ktorým intenzívna kardiovaskulárna ochrana nepriamo prospieva. Ak sa proces nastaví správne, riziká sa dajú zvládnuť a benefity dosiahnuť.</p>

<hr>
<p><em><strong>Zdroj:</strong> Zuo Y-J, Wang J-G. Implementation Strategies for Intensive Blood Pressure Control (komentár). Medscape, 2026. <a href="https://www.medscape.com/s/viewarticle/implementation-strategies-intensive-blood-pressure-control-2026a1000jbh" target="_blank" rel="noopener noreferrer">medscape.com</a>. Diskutovaná je post hoc analýza štúdie ESPRIT (Peng et al., JACC).</em></p>
NEFRO_HTML,
];

// ── Vkladanie do databázy (UPSERT) ──────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

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
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
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
    header('Content-Type: text/plain; charset=utf-8');
    echo "Výsledok: $inserted vložených, $updated aktualizovaných, $skipped bez zmeny | Avíza: $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
}
