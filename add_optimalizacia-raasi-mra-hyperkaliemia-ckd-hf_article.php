<?php
/**
 * add_optimalizacia-raasi-mra-hyperkaliemia-ckd-hf_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie článku: Optimalizácia RAASi/MRA terapie u pacientov so srdcovým
 * zlyhávaním, CKD a hyperkaliémiou (praktický prístup)
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

// ── Dáta článku ────────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Optimalizácia RAASi/MRA terapie u pacientov so srdcovým zlyhávaním, CKD a hyperkaliémiou (praktický prístup)',
    'slug'         => 'optimalizacia-raasi-mra-hyperkaliemia-ckd-hf',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d'),
    'is_top'       => 0,
    'excerpt'      => 'RAASi a MRA patria medzi základné liečivá v cardiorenálnom manažmente, ale hyperkaliémia ich často bráni v optimálnom dávkovaní. Namiesto rezignácie je cieľom aktívne riešiť hyperkaliémiu paralelne s titráciou liečby.',
    'content'      => <<<'HTML'
<h2>Úvod</h2>

<p>RAASi (ACEi/ARB) a MRA (mineralokortikoidový receptorový antagonista) patria medzi základné liečivá v manažmente pacientov so srdcovým zlyhávaním a srdcovo-obličkovým prepojením. V reálnej praxi však často narážame na bariéru, ktorou je hyperkaliémia. Namiesto automatického znižovania dávok alebo vysadenia liečby je cieľom moderného prístupu: udržať pacienta na účinnej RAASi/MRA schéme, pričom hyperkaliémiu riešime aktívne, systematicky a predvídateľne.</p>

<h2>Prečo RAASi/MRA „padá" kvôli draslíku</h2>

<p>Najčastejšie dôvody, prečo sa RAASi/MRA v praxi nedosahuje v cielenej dávke alebo sa prerušuje:</p>

<ul>
<li>vysoké východiskové sérové K<sup>+</sup> alebo jeho dynamická variabilita,</li>
<li>zhoršená funkcia obličiek, dehydratácia alebo interkurentné zhoršenie,</li>
<li>liekové interakcie zvyšujúce draslík (napr. kombinácie s inými látkami ovplyvňujúcimi renín-angiotenzín-aldosterónovú os),</li>
<li>nedostatočná preventívna stratégia pre normalizáciu K<sup>+</sup> pred titráciou,</li>
<li>nedostatočné alebo príliš „neskoré" laboratórne monitorovanie po úprave terapie.</li>
</ul>

<p><strong>Pointa:</strong> hyperkaliémia nie je dôvod na rezignáciu na RAASi/MRA, ale signál na aktívnu optimalizáciu stratégie manažmentu draslíka.</p>

<h2>Kľúčový princíp: optimalizuj terapiu a hyperkaliémiu zároveň</h2>

<p>Prakticky to znamená paralelne riešiť dve veci:</p>

<ol>
<li><strong>RAASi/MRA terapia:</strong> zahájiť a titrovať podľa tolerancie a cieľov (HF/CKD prospech).</li>
<li><strong>Draslík:</strong> znížiť riziko a liečiť hyperkaliémiu tak, aby bolo možné udržať a prípadne zvyšovať dávky RAASi/MRA.</li>
</ol>

<p>Tento „dvojkoľajný" prístup znižuje počet situácií, keď pacient skončí na suboptimálnej dávke len preto, že K<sup>+</sup> sa zvyšuje.</p>

<h2>Praktický postup na ambulancii (odporúčanie ako pracovný rámec)</h2>

<h3>1) Pred titráciou: zhodnoť riziko hyperkaliémie</h3>

<p>Skontroluj:</p>

<ul>
<li>aktuálne a trendové hodnoty K<sup>+</sup>,</li>
<li>odhad GFR a dynamiku kreatinínu,</li>
<li>hydratáciu, diuretický režim a prípadné „skryté" zhoršenie stavu,</li>
<li>aktuálne lieky, ktoré môžu draslík zvyšovať,</li>
<li>ďalšie faktory: metabolická acidóza, diétne excesy draslíka (aspoň orientačne), pridružené ochorenia.</li>
</ul>

<p><strong>Cieľom je predpovedať,</strong> nie len reagovať po tom, čo sa K<sup>+</sup> už zvýši.</p>

<h3>2) Titruj RAASi/MRA plánovane, s reálnym monitoringom</h3>

<p>Po zmene dávky je rozumné nastaviť laboratórnu kontrolu tak, aby zachytila trend draslíka včas. V praxi to typicky znamená kontrolu v prvých dňoch až týždňoch podľa lokálneho protokolu a rizikovosti pacienta.</p>

<p>Keď K<sup>+</sup> začne rásť, titráciu a riešenie draslíka sa nemá spomaľovať; problémy sa riešia v momente, keď K<sup>+</sup> už dosahuje výraznejšie hodnoty a problém je "v plnom rozsahu".</p>

<h3>3) Keď K<sup>+</sup> rastie: rieš príčiny + uvoľni cestu pre udržanie RAASi/MRA</h3>

<p>V praxi sa osvedčuje kombinácia krokov, ktoré majú zmysel aj vtedy, keď ide o chronickú hyperkaliémiu:</p>

<ul>
<li><strong>Liečebné úpravy podporujúce kaliurézu:</strong> optimalizuj diuretiká tam, kde dávajú klinický zmysel (najmä u pacientov so sklonom k retencii tekutín).</li>
<li><strong>Preskúmaj diétu draslíka:</strong> nie ako jednorazové „zakázanie", ale ako praktické obmedzenie vysoko draslíkových zdrojov a edukácia, aby pacient vedel, čo reálne riešiť.</li>
<li><strong>Metabolická acidóza:</strong> ak je prítomná, jej korekcia môže zlepšiť acidobázickú situáciu a nepriamo ovplyvniť draslík (riešiť v súlade s lokálnou praxou a stavom pacienta).</li>
<li><strong>Novšie stratégie pre chronickú kontrolu draslíka:</strong> v situáciách, kde sa bez toho RAASi/MRA nedarí udržať v požadovaných dávkach, sa v medzinárodných odporúčaniach spomínajú aj väzbové liečivá na draslík ako nástroj, ktorý umožní pokračovať v RAASi/MRA. To je obzvlášť relevantné, ak ide o opakované alebo perzistujúce zvyšovanie K<sup>+</sup>.</li>
</ul>

<p><strong>Dôležité:</strong> cieľ nie je „iba dostať K<sup>+</sup> na číslo", ale dostať pacienta do stavu, kde môže dlhodobo profitovať z RAASi/MRA.</p>

<h2>Ako nastaviť cieľ a úspech</h2>

<p>Pri takomto manažmente má zmysel definovať úspech minimálne v troch rovinách:</p>

<ul>
<li>pacient má <strong>stabilne prijateľný K<sup>+</sup></strong>,</li>
<li>RAASi/MRA je <strong>udržaná</strong> (ideálne v čo najvyššej tolerovanej dávke),</li>
<li>nevznikajú opakované akútne eskalácie (hospitalizácie kvôli hyperkaliémii, urgentné zmeny terapie).</li>
</ul>

<p>Úspech je teda kombinácia laboratória a klinického kontinuálneho benefitu.</p>

<h2>Časté chyby, ktoré stoja pacientov RAASi/MRA</h2>

<ol>
<li>Reagovanie až v momente výrazného vzostupu draslíka.</li>
<li>Úplné vysadenie RAASi/MRA bez paralelného plánu, ako draslík zvládnuť.</li>
<li>Nezohľadnenie liekových interakcií a „neviditeľnej" dynamiky renálnej funkcie.</li>
<li>Slabá edukácia pacienta o praktických dietetických a režimových veciach.</li>
<li>Nedostatočné monitorovanie po každej úprave dávky.</li>
</ol>

<h2>Záver</h2>

<p>Hyperkaliémia je v cardiorenálnom manažmente čestou prekážkou, ale nemá byť dôvodom na trvalé podliečenie pacienta RAASi/MRA terapiou. Praktický cieľ je udržať a optimalizovať RAASi/MRA tak, že súčasne proaktívne riešime príčiny a máme si pripravený plán na kontrolu draslíka. V článkoch a vzdelávacích programoch tejto témy sa opakovane zdôrazňuje, že „udržanie liečby" je často uskutočniteľné práve vďaka včasnej stratifikácii rizika a cielenej intervencii pri hyperkaliémii.</p>

<hr>

<p><em><strong>Zdroj:</strong> Global Kidney Academy, mikrolearning kurz „Optimizing RAASi/MRA therapy in patients with heart failure, CKD and hyperkalemia: a microlearning curriculum approach". <a href="https://www.globalkidneyacademy.org" target="_blank" rel="noopener noreferrer">Navštíviť zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

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
    }
}

// ── Výsledok ──────────────────────────────────────────────────────────────────

echo "\n═══════════════════════════════════════════════════════════════════════════\n";
echo "VÝSLEDOK VLOŽENIA ČLÁNKOV\n";
echo "═══════════════════════════════════════════════════════════════════════════\n";
echo "Vložené:         " . $inserted . "\n";
echo "Preskočené:      " . $skipped . " (už existuje)\n";
echo "Chyby:          " . count($errors) . "\n";
echo "Newsletter:     " . $queuedTotal . " e-mailov zaradených\n";

if (!empty($errors)) {
    echo "\n⚠️  CHYBY:\n";
    foreach ($errors as $err) {
        echo "  • " . $err . "\n";
    }
}

echo "\n═══════════════════════════════════════════════════════════════════════════\n";
echo ($inserted > 0 ? "✓ Hotovo!" : "✗ Žiadne články neboli vložené") . "\n";
echo "═══════════════════════════════════════════════════════════════════════════\n";
