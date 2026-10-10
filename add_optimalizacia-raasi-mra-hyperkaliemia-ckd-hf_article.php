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
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';

// ── Dáta článku ────────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Optimalizácia RAASi/MRA terapie u pacientov so srdcovým zlyhávaním, CKD a hyperkaliémiou (praktický prístup)',
    'slug'         => 'optimalizacia-raasi-mra-hyperkaliemia-ckd-hf',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d'),
    'is_top'       => 0,
    'excerpt'      => 'RAASi a MRA patria medzi základné liečivá v kardiorenálnom manažmente, ale hyperkaliémia často bráni ich optimálnemu dávkovaniu. Namiesto rezignácie je cieľom aktívne riešiť hyperkaliémiu paralelne s titráciou liečby.',
    'content'      => <<<'HTML'
<figure><a href="img/optimalizacia-raasi-mra-hyperkaliemia-ckd-hf.webp" rel="noopener noreferrer" target="_blank"><img src="img/optimalizacia-raasi-mra-hyperkaliemia-ckd-hf.webp" alt="Váhy so srdcom a obličkou na jednej strane a stúpajúcim stĺpcom draslíkových častíc na druhej" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Poloschematická vizualizácia. Vysadiť liečbu je najjednoduchšie riešenie – a spravidla najhoršie pre pacienta.</figcaption></figure>

<h2>Úvod</h2>

<p>RAASi (ACEi/ARB) a MRA (mineralokortikoidový receptorový antagonista) patria medzi základné liečivá v manažmente pacientov so srdcovým zlyhávaním a srdcovo-obličkovým prepojením. V reálnej praxi však často narážame na bariéru, ktorou je hyperkaliémia. Namiesto automatického znižovania dávok alebo vysadenia liečby sa moderný prístup usiluje udržať pacienta na účinnej schéme RAASi/MRA a hyperkaliémiu riešiť aktívne, systematicky a predvídateľne.</p>

<h2>Prečo RAASi/MRA „padá“ kvôli draslíku</h2>

<p>Najčastejšie dôvody, prečo sa RAASi/MRA v praxi nepodáva v cieľovej dávke alebo sa prerušuje:</p>

<ul>
<li>vysoké východiskové sérové K<sup>+</sup> alebo jeho dynamická variabilita,</li>
<li>zhoršená funkcia obličiek, dehydratácia alebo interkurentné zhoršenie,</li>
<li>liekové interakcie zvyšujúce draslík (napr. kombinácie s inými látkami ovplyvňujúcimi renín-angiotenzín-aldosterónovú os),</li>
<li>nedostatočná preventívna stratégia na normalizáciu K<sup>+</sup> pred titráciou,</li>
<li>nedostatočné alebo príliš „neskoré“ laboratórne monitorovanie po úprave terapie.</li>
</ul>

<p><strong>Podstata:</strong> hyperkaliémia nie je dôvod na rezignáciu na RAASi/MRA, ale signál na aktívnu optimalizáciu stratégie manažmentu draslíka.</p>

<h2>Kľúčový princíp: optimalizuj terapiu a hyperkaliémiu zároveň</h2>

<p>Prakticky to znamená paralelne riešiť dve veci:</p>

<ol>
<li><strong>RAASi/MRA terapia:</strong> začať a titrovať podľa tolerancie a cieľov (prínos pri HF/CKD).</li>
<li><strong>Draslík:</strong> znížiť riziko a liečiť hyperkaliémiu tak, aby bolo možné udržať a prípadne zvyšovať dávky RAASi/MRA.</li>
</ol>

<p>Tento „dvojkoľajný“ prístup znižuje počet situácií, keď pacient skončí na suboptimálnej dávke len preto, že K<sup>+</sup> sa zvyšuje.</p>

<h2>Praktický postup v ambulancii (pracovný rámec)</h2>

<h3>1) Pred titráciou: zhodnoť riziko hyperkaliémie</h3>

<p>Skontroluj:</p>

<ul>
<li>aktuálne a trendové hodnoty K<sup>+</sup>,</li>
<li>odhad GFR a dynamiku kreatinínu,</li>
<li>hydratáciu, diuretický režim a prípadné „skryté“ zhoršenie stavu,</li>
<li>aktuálne lieky, ktoré môžu draslík zvyšovať,</li>
<li>ďalšie faktory: metabolická acidóza, diétne excesy draslíka (aspoň orientačne), pridružené ochorenia.</li>
</ul>

<p><strong>Cieľom je predvídať,</strong> a nie až reagovať po tom, čo sa K<sup>+</sup> zvýši.</p>

<h3>2) Titruj RAASi/MRA plánovane, s reálnym monitoringom</h3>

<p>Po zmene dávky je rozumné nastaviť laboratórnu kontrolu tak, aby zachytila trend draslíka včas. V praxi to typicky znamená kontrolu v prvých dňoch až týždňoch podľa lokálneho protokolu a rizikovosti pacienta.</p>

<p>Keď K<sup>+</sup> začne rásť, titrácia a riešenie draslíka sa nemajú spomaľovať; problémy sa riešia v momente, keď K<sup>+</sup> už dosahuje výraznejšie hodnoty a problém je „v plnom rozsahu“.</p>

<h3>3) Keď K<sup>+</sup> rastie: rieš príčiny + uvoľni cestu pre udržanie RAASi/MRA</h3>

<p>V praxi sa osvedčuje kombinácia krokov, ktoré majú zmysel aj vtedy, keď ide o chronickú hyperkaliémiu:</p>

<ul>
<li><strong>Liečebné úpravy podporujúce kaliurézu:</strong> optimalizuj diuretiká tam, kde dávajú klinický zmysel (najmä u pacientov so sklonom k retencii tekutín).</li>
<li><strong>Prehodnoť príjem draslíka v strave:</strong> nie ako jednorazový zákaz, ale ako praktické obmedzenie zdrojov s vysokým obsahom draslíka a edukáciu, aby pacient vedel, čo reálne riešiť.</li>
<li><strong>Metabolická acidóza:</strong> ak je prítomná, jej korekcia môže zlepšiť acidobázickú situáciu a nepriamo ovplyvniť draslík (riešiť v súlade s lokálnou praxou a stavom pacienta).</li>
<li><strong>Novšie stratégie pre chronickú kontrolu draslíka:</strong> ak sa bez nich RAASi/MRA nedarí udržať v požadovaných dávkach, medzinárodné odporúčania uvádzajú aj liečivá viažuce draslík ako nástroj, ktorý umožní v RAASi/MRA pokračovať. Týka sa to najmä opakovaného alebo pretrvávajúceho zvyšovania K<sup>+</sup>.</li>
</ul>

<p><strong>Dôležité:</strong> cieľ nie je „iba dostať K<sup>+</sup> na číslo“, ale dostať pacienta do stavu, v ktorom môže dlhodobo profitovať z RAASi/MRA.</p>

<h2>Ako nastaviť cieľ a úspech</h2>

<p>Pri takomto manažmente má zmysel definovať úspech minimálne v troch rovinách:</p>

<ul>
<li>pacient má <strong>stabilne prijateľný K<sup>+</sup></strong>,</li>
<li>RAASi/MRA je <strong>udržaná</strong> (ideálne v čo najvyššej tolerovanej dávke),</li>
<li>nevznikajú opakované akútne eskalácie (hospitalizácie kvôli hyperkaliémii, urgentné zmeny terapie).</li>
</ul>

<p>Úspech teda zahŕňa laboratórny výsledok aj trvalý klinický prínos.</p>

<h2>Časté chyby, pre ktoré pacienti prichádzajú o RAASi/MRA</h2>

<ol>
<li>Reakcia až vo chvíli výrazného vzostupu draslíka.</li>
<li>Úplné vysadenie RAASi/MRA bez paralelného plánu, ako draslík zvládnuť.</li>
<li>Nezohľadnenie liekových interakcií a „neviditeľnej“ dynamiky renálnej funkcie.</li>
<li>Slabá edukácia pacienta o praktických diétnych a režimových opatreniach.</li>
<li>Nedostatočné monitorovanie po každej úprave dávky.</li>
</ol>

<h2>Záver</h2>

<p>Hyperkaliémia je v kardiorenálnom manažmente častou prekážkou, ale nemá byť dôvodom na trvalé podliečenie pacienta RAASi/MRA terapiou. Cieľom je udržať a optimalizovať RAASi/MRA, súčasne proaktívne riešiť príčiny hyperkaliémie a mať pripravený plán na kontrolu draslíka. Vzdelávacie programy k tejto téme opakovane zdôrazňujú, že udržať liečbu sa často darí práve vďaka včasnej stratifikácii rizika a cielenej intervencii pri hyperkaliémii.</p>

<hr>

<p><em><strong>Zdroj:</strong> Global Kidney Academy, mikrolearning kurz „Optimizing RAASi/MRA therapy in patients with heart failure, CKD and hyperkalemia: a microlearning curriculum approach“. <a href="https://www.globalkidneyacademy.org" target="_blank" rel="noopener noreferrer">Navštíviť zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie po úprave obsahu prepíše článok (regenerácia).
// Newsletter avízo LEN pri prvom vložení (rc === 1).
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
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
    }
}

// ── Výsledok ──────────────────────────────────────────────────────────────────

echo "\n═══════════════════════════════════════════════════════════════════════════\n";
echo "VÝSLEDOK VLOŽENIA ČLÁNKOV\n";
echo "═══════════════════════════════════════════════════════════════════════════\n";
echo "Vložené:         " . $inserted . "\n";
echo "Aktualizované:   " . $updated . "\n";
echo "Preskočené:      " . $skipped . " (bez zmeny)\n";
echo "Chyby:          " . count($errors) . "\n";
echo "Newsletter:     " . $queuedTotal . " e-mailov zaradených\n";

if (!empty($errors)) {
    echo "\n⚠️  CHYBY:\n";
    foreach ($errors as $err) {
        echo "  • " . $err . "\n";
    }
}

echo "\n═══════════════════════════════════════════════════════════════════════════\n";
echo (($inserted > 0 || $updated > 0) ? "✓ Hotovo!" : "✗ Žiadne články neboli vložené/aktualizované") . "\n";
echo "═══════════════════════════════════════════════════════════════════════════\n";
