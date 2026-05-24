<?php
/**
 * add_preeklampsia_oblicky_article.php
 * Pridanie článku o preeklampsii, mechanizmoch poškodenia obličiek a klinických dôsledkoch
 * Prístupné len pre prihlásených adminov alebo z CLI.
 * Po spustení migrácie môžete tento súbor odstrániť alebo ponechať (idempotentný – vkladá len chýbajúce).
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Preeklampsia a obličky: prečo vzniká poškodenie a čo z toho plynie pre prax',
    'slug'         => 'preeklampsia-a-oblicky-poskodenie-mechanizmy-a-prax',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-24',
    'is_top'       => 0,
    'excerpt'      => 'Preeklampsia nie je len hypertenzia v tehotenstve — ide o systémovú endotelovú poruchu, ktorá sa v obličkách prejavuje glomerulárnou dysfunkciou, proteinúriou a možným akútnym zhoršením funkcie. Review v Nature Reviews Nephrology vysvetľuje mechanizmy poškodenia a ich klinické dôsledky vrátane dlhodobých renálnych rizík po pôrode.',
    'content'      => <<<'HTML'
<p>Preeklampsia je závažná komplikácia gravidity, pri ktorej sa kombinuje <strong>novovzniknutá hypertenzia</strong> s následnou <strong>dysfunkciou orgánov</strong> (u časti žien vrátane obličiek) a s nepriaznivým vplyvom na plod. Review v <em>Nature Reviews Nephrology</em> sa sústreďuje najmä na mechanizmy vzniku ochorenia a na to, ako tieto mechanizmy vysvetľujú renálne prejavy a riziká.</p>

<p>Nižšie prinášame pohľad na to, čo to znamená prakticky — s nefrologickým dôrazom.</p>

<h2>Základný princíp: placenta spúšťa systémovú dysfunkciu</h2>

<p>Najčastejšie používaný „dvojfázový" rámec (v literatúre veľmi konzistentný) vychádza z toho, že:</p>

<ol>
  <li><strong>Založenie placenty</strong> neprebieha optimálne — placentárna perfúzia je nedostatočná.</li>
  <li>Placenta uvoľňuje signály, ktoré vedú k <strong>celotelovej endotelovej (cievnej) dysfunkcii</strong>.</li>
  <li>Výsledkom je nerovnováha medzi faktormi podporujúcimi angiogenézu a „antiangiogénnymi" vplyvmi, čo vedie k rozvoju patofyziologických prejavov.</li>
</ol>

<p>Pre obličky je kľúčové, že tento proces nie je len „o tlaku", ale o <strong>poruche funkcie cievneho endotelu</strong> v systémovom meradle. Oblička je orgán s bohatou mikrocirkuláciou, takže sa stáva obzvlášť citlivým cieľom.</p>

<h2>Prečo sa preeklampsia prejaví aj v obličkách</h2>

<p>V obličkách sa pri preeklampsii často popisujú zmeny na úrovni glomerúl, ktoré vedú k klinickým symptómom:</p>

<ul>
  <li><strong>proteinúria</strong>,</li>
  <li>zhoršenie funkcie obličiek (od miernych zmien až po akútne zhoršenie),</li>
  <li>zmeny perfúzie a mikrocirkulácie v renálnom tkanive.</li>
</ul>

<p>Mechanisticky to možno zhrnúť takto: endotelová dysfunkcia a downstream mediátory spustia stav, ktorý sa v obličkovej terminológii približuje k pojmu „glomerulárna endotelová porucha" — klinicky zodpovedá proteinúrii a poruche filtrácie. Dôležité je, že nejde o jediný izolovaný mechanizmus, ale o <strong>sieť signálov</strong>, ktorá sa prejaví v rôznych časoch gravidity a s rôznou závažnosťou.</p>

<h2>Medzi proteinúriou a obličkovým zlyhaním je rozdiel</h2>

<p>Pre pacienta je prirodzená otázka: keď vidíme proteinúriu, je to automaticky zlyhanie obličiek? Nie nevyhnutne.</p>

<ul>
  <li><strong>Proteinúria</strong> môže byť prejavom glomerulárnej poruchy filtračnej bariéry.</li>
  <li><strong>Akútne zhoršenie obličiek</strong> závisí od viacerých faktorov: závažnosti systémovej endotelovej dysfunkcie, rozsahu cievnej zmeny, individuálnej rezervy obličiek, prítomnosti rizikových komorbidít a načasovania klinickej intervencie.</li>
</ul>

<p>Nefrologicky to znamená, že nesmieme „zredukovať" preeklampsiu len na jednu laboratórnu hodnotu. Pre interpretáciu je podstatné sledovať trend a kontext: tlak, symptómy, renálne parametre, hydratáciu a metabolické dopady.</p>

<h2>Praktický dopad: ako rozmýšľať v tehotenstve</h2>

<p>Ak sa v gravidite objaví podozrenie na preeklampsiu alebo sa potvrdí, klinická logika by mala byť:</p>

<h3>1) Potvrdiť a triediť závažnosť</h3>

<p>Zvyčajne ide o kombináciu hypertenzie, proteinúrie (alebo iných prejavov orgánovej dysfunkcie) a laboratórnych ukazovateľov rizika. V nefrologickej praxi ide najmä o sledovanie trendu:</p>

<ul>
  <li>kreatinínu a odhadovanej GFR,</li>
  <li>proteinúrie,</li>
  <li>rovnováhy tekutín,</li>
  <li>komplikácií, ktoré môžu nepriamo zhoršovať obličkovú perfúziu (napr. zvracanie, horúčka, krvácanie, potreba intenzívnej liečby).</li>
</ul>

<h3>2) Premýšľať, čo je liečiteľné teraz a čo je riziko neskôr</h3>

<p>Preeklampsia je akútna udalosť, ale následky môžu pretrvávať. Z nefrologického pohľadu:</p>

<ul>
  <li><strong>Krátkodobo:</strong> zabrániť progresii k závažnej obličkovej dysfunkcii v rámci možností.</li>
  <li><strong>Dlhodobo:</strong> u žien po preeklampsii býva vyššie riziko kardiovaskulárnych a renálnych problémov — je vhodné plánovať kontrolu po pôrode a v čase.</li>
</ul>

<h3>3) Nepodceňovať faktory, ktoré obličky zhoršujú sekundárne</h3>

<p>Aj keď centrom príbehu je endotel a glomeruly, obličkám často škodia sekundárne faktory: hypovolémia (napr. pri výraznej nevoľnosti a zvracaní), infekcie, liekové zásahy a ich načasovanie či kardiovaskulárna nestabilita.</p>

<p>V praxi to znamená: nefrologické myslenie je interdisciplinárne — nejde len o „kreatinín", ale o celkový klinický stav.</p>

<h2>Prečo neexistuje jedna liečba na všetko</h2>

<p>Pri preeklampsii je tradičný problém, že mechanizmy sú viaceré a paralelné a nie je jednoduché zasiahnuť presne v bode, ktorý je rozhodujúci pre obličky a zároveň bezpečný pre matku aj plod.</p>

<p>Preto praktické odporúčanie znie: aj keď mechanizmy znejú „biologicky elegantne", klinika sa riadi tým, čo znižuje akútne riziko a umožní bezpečné zvládnutie tehotenstva — nie iba „korekciou jedného biomarkera".</p>

<h2>Zhrnutie pre prax</h2>

<p>Preeklampsia nie je len „hypertenzia v tehotenstve". Ide o systémovú endotelovú poruchu, ktorá sa v obličkách prejavuje glomerulárnou dysfunkciou a môže viesť k proteinúrii aj k zhoršeniu funkcie obličiek. Preto je nefrologicky dôležité sledovať nielen jednu hodnotu, ale celý klinický obraz a trend renálnych parametrov, a zároveň myslieť aj na dlhodobé renálne a kardiovaskulárne riziká po pôrode.</p>

<hr>

<p><em><strong>Zdroj:</strong> Nature Reviews Nephrology – „Preeclampsia and the kidney". <a href="https://www.nature.com/articles/s41581-026-01085-x" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>

<p><em><strong>Upozornenie:</strong> Tento článok bol osobne spracovaný aj s pomocou rozličných nástrojov tzv. umelej inteligencie (AI).</em></p>
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
                error_log('add_preeklampsia_oblicky_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_preeklampsia_oblicky_article error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migracia clanku: Preeklampsia a oblicky\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Vysledok: $inserted z $total clankov bolo vlozenych.\n";
    echo "Preskoceni (slug uz existuje): $skipped\n";
    echo "Zara dených do fronty aviz:    $queuedTotal\n";
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
      <title>Migrácia – Preeklampsia a obličky</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
        <div class="auth-container">
          <h2>Migrácia – Preeklampsia a obličky</h2>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
              <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
            </div>
          <?php endif; ?>

          <div class="alert <?= $inserted > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> z <?= $total ?> článkov bolo vložených. <?= $skipped ?> preskočených (slug už existuje).</p>
            <?php if ($queuedTotal > 0): ?>
              <p>Do fronty avíz zaradených: <strong><?= $queuedTotal ?></strong> e-mailov.</p>
            <?php endif; ?>
          </div>

          <ul>
            <?php foreach ($articles as $a): ?>
              <li><strong><?= htmlspecialchars($a['title']) ?></strong> (slug: <code><?= htmlspecialchars($a['slug']) ?></code>)</li>
            <?php endforeach; ?>
          </ul>

          <p style="margin-top:30px;">
            <a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a>
            &nbsp;
            <a href="admin_articles.php" class="btn-secondary-small">Správa článkov</a>
          </p>

          <p style="margin-top:30px;font-size:0.85rem;color:var(--text-secondary);">
            Tento súbor môžete po úspešnej migrácii odstrániť alebo ponechať – je idempotentný (vkladá len chýbajúce záznamy).
          </p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
