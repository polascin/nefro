<?php
/**
 * add_pre-pacientov-uvod_article.php
 * Prvý (uvítací) popularizačný článok sekcie „Pre pacientov".
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_pre-pacientov-uvod_article.php"
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať popularizačný článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';

$articles = [];

$articles[] = [
    'title'        => 'Vitajte v sekcii „Pre pacientov“',
    'slug'         => 'pre-pacientov-uvod',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 1,
    'excerpt'      => 'Nová sekcia, kde o obličkách, ich ochoreniach a liečbe píšeme jednoducho a zrozumiteľne — pre pacientov a ich blízkych.',
    'content'      => <<<'HTML'
<figure>
  <img src="img/pre_pacientov_1.png" alt="Ilustrácia obličiek a okolo nich symboly starostlivosti o ne — pohár vody, pohyb, ovocie a zelenina, srdce a laboratórne hodnoty (kreatinín, eGFR)" loading="lazy" decoding="async">
  <figcaption>Obličky sú malé, no pre naše zdravie nenahraditeľné orgány.</figcaption>
</figure>

<p>Vitajte v novej sekcii <strong>Pre pacientov</strong>. Nájdete tu články o obličkách
napísané <em>ľudskou rečou</em> — bez zložitých odborných výrazov. Sú určené pacientom,
ich rodinám a každému, koho zaujíma, ako sa o svoje obličky starať.</p>

<h2>Čo tu nájdete</h2>

<ul>
  <li>Ako obličky fungujú a prečo sú dôležité.</li>
  <li>Čo znamenajú výsledky bežných vyšetrení (napríklad kreatinín či eGFR).</li>
  <li>Praktické rady o strave, pití a pohybe pri ochorení obličiek.</li>
  <li>Vysvetlenie liečby — od liekov až po dialýzu a transplantáciu.</li>
</ul>

<h2>Ako články čítať</h2>

<p>Každý článok sa snaží odpovedať na jednu otázku jednoducho a názorne, často s obrázkom.
Odborné skratky vždy aspoň raz vysvetlíme. Ak vám niečo nie je jasné, opýtajte sa svojho
lekára — tieto články <strong>nenahrádzajú</strong> osobné vyšetrenie ani odbornú radu.</p>

<p>Chcete dostávať nové články priamo do e-mailu? Prihláste sa na bezplatný odber noviniek
nižšie na tejto stránke.</p>

<hr>

<p><em><strong>Upozornenie:</strong> Obsah má informačný a vzdelávací charakter a nenahrádza
konzultáciu s lekárom.</em></p>

<figure>
  <img src="img/pre_pacientov_2.png" alt="Ilustrácia zdravých obličiek a okolo nich zdravý životný štýl a rodina — srdce, laboratórne vyšetrenia, vyvážená strava, pitný režim, pohyb, lieky a podpora blízkych" loading="lazy" decoding="async">
  <figcaption>O svoje obličky sa dá starať každý deň — a nie ste v tom sami.</figcaption>
</figure>
HTML,
];

$inserted    = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT IGNORE INTO articles (title, slug, author, content, excerpt, category, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, 'popularne', :published_at, :is_top, 1)"
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
                error_log('add_popular_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_popular_article migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo "Popularizačný článok: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted z $total vložených. Preskočené: $skipped. Avíza: $queuedTotal\n";
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
