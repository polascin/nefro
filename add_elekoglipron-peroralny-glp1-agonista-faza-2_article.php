<?php
/**
 * add_elekoglipron-peroralny-glp1-agonista-faza-2_article.php
 * Odborný článok (úvodná stránka, kategória 'odborne').
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_elekoglipron-peroralny-glp1-agonista-faza-2_article.php"
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

$articles = [];

$articles[] = [
    'title'        => 'Nový perorálny GLP-1 agonista elekoglipron: výsledky fázy 2 so zlepšením HbA1c a redukciou hmotnosti',
    'slug'         => 'elekoglipron-peroralny-glp1-agonista-faza-2',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Elekoglipron, perorálny malomolekulový GLP-1 agonista, dosiahol v dvoch štúdiách fázy 2 (SOLSTICE a VISTA) klinicky významné zníženie HbA1c a redukciu hmotnosti. Dlhodobé renálne outcome zatiaľ preukázané nie sú.',
    'content'      => <<<'HTML'
<p><strong>Elekoglipron</strong> je nový perorálny agonista receptora pre GLP-1 (malá molekula). V dvoch štúdiách fázy 2 dosiahol <strong>klinicky významné zníženie HbA1c a glukózy</strong> u ľudí s diabetom 2. typu a zároveň <strong>významnú redukciu hmotnosti</strong> u populácie s obezitou alebo nadváhou (bez diabetu 2. typu).</p>

<h2>Prečo je to zaujímavé aj z nefrologického pohľadu</h2>

<p>Chronická hyperglykémia a obezita sú spojené s vyšším rizikom kardiometabolických komplikácií a aj poškodenia obličiek. Kombinácia účinku na metabolizmus a hmotnosť by teoreticky mohla viesť k zlepšeniu kardiometabolických profilov, ktoré zahŕňajú aj rizikové faktory pre kardiovaskulárne a renálne udalosti.</p>

<div class="info-box-yellow">
<p><strong>Dôležité upozornenie.</strong> Ide primárne o <strong>výsledky fázy 2</strong>. Dlhodobé renálne outcome (tvrdé obličkové ciele) v tejto fáze <strong>ešte nie sú preukázané</strong> a budú predmetom ďalších štúdií.</p>
</div>

<h2>SOLSTICE (fáza 2b): diabetes 2. typu, HbA1c a hmotnosť</h2>

<p>Do štúdie bolo zaradených <strong>406</strong> pacientov s diabetom 2. typu. Randomizácia zahŕňala:</p>

<ul>
  <li>perorálne dávky elekoglipronu <strong>5 mg, 15 mg alebo 25 mg</strong> raz denne,</li>
  <li>rôzne schémy titrácie (vrátane cieľových dávok a eskalácie),</li>
  <li>placebo,</li>
  <li>a exploratórnu skupinu s perorálnym semaglutidom titrovaným na 14 mg.</li>
</ul>

<h3>Výsledky za 26 týždňov</h3>

<ul>
  <li><strong>HbA1c klesalo dávkovo závisle</strong> a vo všetkých dávkach bolo zníženie väčšie než placebo. Uvádzaný rozsah: zníženie približne <strong>0,91 %</strong> pri 5 mg až <strong>1,88 %</strong> pri najvyššej dávke v schéme eskalácie.</li>
  <li><strong>Hmotnosť klesala</strong> tiež v závislosti od dávky: približne <strong>2,54 %</strong> (5 mg) až <strong>7,61 %</strong> pri najvyššej dávke pri eskalácii každé 2 týždne.</li>
  <li>Pri schéme s najvyššou dávkou dosiahol <strong>väčší podiel pacientov aspoň 5 % redukciu hmotnosti</strong> oproti placebu.</li>
  <li>Zaznamenané boli aj zlepšenia niektorých <strong>markerov krvného tlaku a pečeňových biomarkerov</strong>.</li>
</ul>

<h3>Bezpečnosť a tolerancia</h3>

<ul>
  <li>Nežiaduce udalosti boli v súlade s triedou GLP-1 (gastrointestinálne príznaky).</li>
  <li>Najčastejšie boli <strong>nauzea, zápcha, hnačka, vrátane vracania</strong>.</li>
  <li>Časť pacientov musela liečbu ukončiť pre nežiaduce účinky, najmä pri vyšších dávkach a určitých titračných schémach.</li>
</ul>

<h2>VISTA (fáza 2): obezita alebo nadváha s komorbiditou, bez diabetu 2. typu</h2>

<p>Do VISTA bolo zaradených <strong>310</strong> účastníkov s obezitou alebo nadváhou s aspoň jednou hmotnostne súvisiacou komorbiditou a <strong>bez diabetu 2. typu</strong>.</p>

<h3>Dávkovanie</h3>

<ul>
  <li>týždenné titrovanie elekoglipronu v rôznych dávkach,</li>
  <li>vrátane režimu s titráciou každé 2 týždne (pri 75 mg),</li>
  <li>placebo.</li>
</ul>

<h3>Výsledky za 26 týždňov</h3>

<ul>
  <li>Priemerná redukcia telesnej hmotnosti sa pohybovala približne od <strong>2,6 %</strong> (najnižšia dávka) po <strong>10,5 %</strong> (najvyššia týždenná titrácia) oproti <strong>0,6 %</strong> v skupine placeba.</li>
  <li>Ko-primárny cieľ (podiel pacientov s aspoň 5 % redukciou hmotnosti) bol <strong>88,8 %</strong> v elekoglipronovej skupine vs. <strong>15,6 %</strong> na placebe.</li>
  <li>Pri predĺžení na <strong>36 týždňov</strong> sa pri niektorých ukazovateľoch redukcia hmotnosti ďalej zvyšovala a nedošlo k jasnému „plateau“ už po 26 týždňoch.</li>
</ul>

<h3>Bezpečnosť</h3>

<p>Nežiaduce udalosti boli podobného typu ako v SOLSTICE: opäť najmä gastrointestinálne príznaky.</p>

<h2>Porovnanie s injekčnými inkretínovými terapiami</h2>

<p>Výsledná miera redukcie hmotnosti s elekoglipronom je <strong>porovnateľná s inými perorálnymi malomolekulovými GLP-1 agonistami</strong>, ale <strong>nižšia než miery hlásené pri niektorých injekčných inkretínových terapiách</strong> s vyššou účinnosťou v redukcii hmotnosti.</p>

<p>Súčasne sa zdôrazňuje praktický benefit: <strong>perorálne podanie</strong> bez potreby prísnych režimových obmedzení, ktoré môžu byť problematické pri niektorých iných perorálnych GLP-1 liekoch.</p>

<h2>Čo z toho vyplýva do praxe a čo ešte chýba</h2>

<p>Tieto výsledky <strong>odôvodňujú pokračovanie</strong> do fázy 3 (dlhšie sledovanie, širší výber populácie, relevantné kardiometabolické outcome a optimalizácia dávok a titračných schém).</p>

<p>Pre nefrologickú prax je kľúčové rozlišovať:</p>

<ul>
  <li><strong>čo už vieme:</strong> zlepšenia HbA1c a telesnej hmotnosti v štúdiách fázy 2,</li>
  <li><strong>čo ešte nevieme:</strong> či sa tieto zmeny premietnu do konkrétnych dlhodobých <strong>renálnych outcome</strong> (predmet ďalších štúdií).</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, „Novel Oral GLP-1 Shows A1c and Weight Loss Benefits“ (ADA 2026; SOLSTICE a VISTA). <a href="https://www.medscape.com/viewarticle/novel-oral-glp-1-shows-a1c-and-weight-loss-benefits-2026a1000jwl" target="_blank" rel="noopener noreferrer">medscape.com</a></em></p>

<p><em><strong>Upozornenie:</strong> Článok má informačný a vzdelávací charakter, sumarizuje publikované výsledky fázy 2 a nenahrádza odborné posúdenie ani aktuálne schválené indikácie a SPC.</em></p>
HTML,
];

$inserted    = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT IGNORE INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)"
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
        if ($stmt->rowCount() > 0) {
            $inserted++;
            $newId = (int) $pdo->lastInsertId();
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $newId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $skipped++;
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
    echo "Migrácia článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted z $total článkov bolo vložených.\n";
    echo "Preskočení (slug už existuje): $skipped\n";
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
    echo "Vložených: $inserted, preskočených: $skipped, avíz: $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
}
?>
