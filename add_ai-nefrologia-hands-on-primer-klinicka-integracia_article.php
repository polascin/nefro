<?php
/**
 * add_ai-nefrologia-hands-on-primer-klinicka-integracia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok — slovenské spracovanie zdroja „AI in Nephrology Hands-On
 * Primer“ (Kidney News, ASN). Idempotentný UPSERT (viď add_TEMPLATE_article.php).
 * Pôvodní autori zdroja sú v source_authors.php (mapa slug → mená).
 * ════════════════════════════════════════════════════════════════════════════
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
    'title'        => 'AI v nefrológii v praxi: čo prináša „Hands-On Primer“ pre klinické myslenie a bezpečnú integráciu',
    'slug'         => 'ai-nefrologia-hands-on-primer-klinicka-integracia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => '2026-06-21 19:30:00',
    'is_top'       => 0,
    'excerpt'      => 'Workshop ASN ukázal, že AI je v nefrológii prítomná už dnes. Praktické aplikácie generatívnej AI – syntéza literatúry, dokumentácia, analýza obrazu – aj jej limity: halucinácie, nereprodukovateľnosť a nutnosť ľudskej kontroly.',
    'content'      => <<<'HTML'
<p>Rýchly nástup umelej inteligencie (AI) v medicíne už nie je len technologická kuriozita. Mení spôsob, akým klinici vyhľadávajú informácie, syntetizujú dôkazy a pracujú s klinickými dátami. Článok „AI in Nephrology Hands-On Primer: Practical Applications and Clinical Integration“ sa zameriava na praktickú rovinu tejto zmeny – na skúsenosti z workshopu venovaného práci s dátovou a generatívnou AI v nefrológii, teda na to, ako sa tieto nástroje premietajú do bežných pracovných tokov.</p>

<h2>Prečo je „hands-on“ prístup dôležitý</h2>
<p>Workshop (konaný 16. – 17. marca 2026 v New Yorku) ukázal, že AI je v klinickom uvažovaní prítomná už dnes. Nešlo len o pasívne zoznámenie sa, ale o model „použi, uvidíš, skontroluj“. Z pohľadu lekárov v príprave (tzv. trainees) je to podstatné, lebo riziko pri AI nespočíva len v tom, že „sa môže pomýliť“, ale aj v tom, že sa môže pomýliť presvedčivo – a zakaždým inak, podľa toho, aký nástroj a aký prompt použijeme.</p>

<h2>Generatívne modely: užitočnosť, ale nie „porozumenie“</h2>
<p>Autori prirovnávajú súčasnú vlnu generatívnej AI k obdobiu rýchleho rozšírenia internetu: rýchla adopcia, prudký rast schopností a zároveň výrazné neistoty. Veľké jazykové modely (LLM) dokážu v priebehu sekúnd:</p>
<ul>
  <li>zhrnúť rozsiahle publikácie,</li>
  <li>pomôcť pri tvorbe klinickej dokumentácie,</li>
  <li>podporiť rozhodovacie pracovné postupy.</li>
</ul>
<p>Zároveň však zdôrazňujú zásadný limit: ide o pravdepodobnostné rozpoznávanie vzorcov, nie o „skutočné porozumenie“. Praktické dôsledky sú:</p>
<ul>
  <li><strong>halucinácie</strong> (vytváranie nepresných informácií),</li>
  <li><strong>chyby v kontexte</strong>,</li>
  <li><strong>nestálosť výstupov</strong> medzi modelmi a platformami.</li>
</ul>

<h2>Jedna úloha, viac výsledkov: problém reprodukovateľnosti</h2>
<p>Jedným z najvýraznejších zistení workshopu bola nekonzistentnosť medzi platformami. Identické zadania môžu viesť k výrazne odlišným odpovediam naprieč nástrojmi (napríklad ChatGPT, Gemini a Claude). V klinickej praxi, kde sú reprodukovateľnosť a spoľahlivosť rozhodujúce, je to zásadná prekážka.</p>
<p>Z praktického hľadiska to znamená, že klinik nemôže posudzovať výstup AI ako „jedinú pravdu“. Potrebuje:</p>
<ul>
  <li><strong>overenie informácií</strong>,</li>
  <li>porovnanie s relevantnými zdrojmi alebo vlastnou klinickou skúsenosťou,</li>
  <li>opatrnosť pri rozhodnutiach s priamym dopadom na pacienta.</li>
</ul>

<h2>Aké typy AI nástrojov sa dnes používajú (podľa funkcie)</h2>
<p>Workshop ukázal, že AI sa už nevyvíja len ako izolovaná aplikácia, ale ako súbor nástrojov pre konkrétne časti pracovného toku. Zhruba ich možno rozdeliť na funkčné okruhy:</p>
<ol>
  <li><strong>Syntéza znalostí a literatúry</strong> – nástroje na štruktúrované zhrnutie článkov a extrakciu kľúčových zistení (napr. NotebookLM).</li>
  <li><strong>Klinická dokumentácia a podpora pracovného toku</strong> – platformy na generovanie poznámok, zhrnutí a integráciu do existujúcich postupov (napr. DoxGPT, Microsoft Copilot).</li>
  <li><strong>Vizualizácie a komunikácia</strong> – pomoc pri tvorbe grafov, diagramov a vzdelávacích materiálov (napr. Canva, Napkin AI).</li>
  <li><strong>Podpora založená na dôkazoch</strong> – nástroje, ktoré sa snažia ukotviť odpovede v prepojenom, referencovanom obsahu (napr. OpenEvidence).</li>
</ol>
<p>Podstatné je, že „dobrá“ AI pre klinika nie je nutne jedno veľké riešenie. Skôr ide o schopnosť kombinovať nástroje v pracovnom toku tak, aby človek ostal poslednou rozhodovacou autoritou.</p>

<h2>Praktické príklady z nefrológie: kde AI pomáha a kde treba opatrnosť</h2>

<h3>1) Zhrnutie a syntéza literatúry</h3>
<p>Pri workshopových úlohách AI dobre zvládla:</p>
<ul>
  <li>zhrnutie zložitých výskumných prác,</li>
  <li>extrakciu kľúčových výsledkov,</li>
  <li>generovanie štruktúrovaných výstupov vhodných na prezentácie.</li>
</ul>
<p>Významným prínosom bola úspora času. Autori však jasne upozorňujú, že výstupy treba <strong>overiť</strong> – z hľadiska presnosti aj úplnosti.</p>

<h3>2) Analýza obrazu: hodnotenie diéty a exit-site pri peritoneálnej dialýze</h3>
<p>Zaujímavá časť bola venovaná vizuálnym úlohám:</p>
<ul>
  <li>posúdenie diéty z fotografií,</li>
  <li>hodnotenie exit-site (miesta výstupu) peritoneálneho dialyzačného katétra.</li>
</ul>
<p>AI niekedy dosiahla vysokú zhodu s expertom. Autori zároveň opisujú typické obmedzenia:</p>
<ul>
  <li>citlivosť na kvalitu obrazu,</li>
  <li>zraniteľnosť voči chybám,</li>
  <li>potrebu klinického kontextu,</li>
  <li>širšie riziká, ako sú skreslenie (bias) a variabilita vstupov.</li>
</ul>
<p>Z toho vyplýva praktické pravidlo: aj keď AI „vyzerá, že sa trafila“, bez klinického kontextu a bez systematického overenia v danej populácii je náhrada odborného úsudku zatiaľ nereálna.</p>

<h3>3) Klinické scenáre: rôzne modely vedú k rôznym úvahovým cestám</h3>
<p>Pri testovaní LLM v klinických scenároch produkovali rôzne modely odlišné odporúčania aj odlišnú logickú štruktúru argumentácie. To je dôležité, pretože v medicíne nie je problémom len „koncové tvrdenie“, ale aj to, <strong>ako</strong> sa k nemu model dopracuje.</p>
<p>Praktický dôsledok: výstup treba krížovo kontrolovať a klinickú zodpovednosť ponechať na človeku.</p>

<h2>NephroResource a cesta od „schopnosti“ k „nástroju“</h2>
<p>Workshop spomenul aj úsilie premeniť AI na klinicky použiteľné rozhrania. Jedným z príkladov je <strong>NephroResource</strong> – webová platforma s kurátorsky spracovanými nefrologickými informáciami, ktorá sa prezentuje ako premostenie medzi všeobecnými schopnosťami AI a praktickou aplikáciou vo vzdelávacích alebo podporných klinických úlohách.</p>

<h2>Budovanie komunity: učenie sa z praxe, nie len z prezentácií</h2>
<p>Autori kladú dôraz na komunitne riadené vzdelávanie. ASN (American Society of Nephrology) organizuje workshopy a AI-komunity a zdôrazňuje, že pre nefrológov bude kľúčové:</p>
<ul>
  <li>držať krok s vývojom,</li>
  <li>vymieňať si praktické know-how,</li>
  <li>spoločne formovať zodpovedné používanie AI.</li>
</ul>
<p>Záver článku je v podstate jasný: integrácia AI do nefrológie už nie je hypotetická. Hlavnou otázkou teraz je, <strong>ako ju používať efektívne, bezpečne a rozumne</strong> v reálnej klinickej praxi.</p>

<hr>
<p><em><strong>Zdroj:</strong> Noppawit Aiumtrakul, Arjunmohan Mohan, Harshil A. Fichadiya, Wisit Cheungpasitporn. „AI in Nephrology Hands-On Primer: Practical Applications and Clinical Integration“, <em>Kidney News</em> (ASN), ročník 18, číslo 5. <a href="https://www.kidneynews.org/view/journals/kidney-news/18/5/article-p10_7.xml" target="_blank" rel="noopener noreferrer">kidneynews.org</a>.</em></p>
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
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
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
