<?php

declare(strict_types=1);

/**
 * One-shot konverzia existujúcich add_*_article.php skriptov na zdieľaný
 * upsertArticles() helper z article_publisher.php.
 *
 * Spustenie:
 *   php tools/convert_upsert_to_helper.php
 */

$root = __DIR__ . '/..';
$files = glob($root . '/add_*_article.php');
if ($files === false) {
    fwrite(STDERR, "Nenašli sa žiadne súbory\n");
    exit(1);
}

$skippedFiles = [];
$convertedFiles = [];

foreach ($files as $file) {
    $content = (string) file_get_contents($file);
    if ($content === '') {
        $skippedFiles[] = basename($file) . ' (prázdny súbor)';
        continue;
    }

    // Už konvertované súbory (obsahujú upsertArticles) preskočíme.
    if (str_contains($content, 'upsertArticles(')) {
        $skippedFiles[] = basename($file) . ' (už používa upsertArticles)';
        continue;
    }

    // Nájdi blok medzi "Vkladanie do databázy" a "$total = count($articles);"
    $startMarker = '// ── Vkladanie do databázy ──────────────────────────────────────────────────────';
    $endMarker = '$total = count($articles);';
    $pattern = '/' . preg_quote($startMarker, '/') . '(.*?)' . preg_quote($endMarker, '/') . '/su';
    if (!preg_match($pattern, $content, $matches)) {
        $skippedFiles[] = basename($file) . ' (nenájdený vkladací blok)';
        continue;
    }

    $block = $matches[0];

    // Určíme kategóriu z SQL (VALUES alebo ON DUPLICATE KEY UPDATE).
    if (!preg_match("/category\s*=\s*'(\w+)'/", $block, $catMatch)) {
        $skippedFiles[] = basename($file) . ' (nenájdená kategória)';
        continue;
    }
    $category = $catMatch[1];

    $enqueueNewsletter = str_contains($block, 'enqueueArticleNewsletterEmails') ? 'true' : 'false';

    $newBlock = <<<'PHP'
// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$__articleLogPrefix = basename(__FILE__, '.php');
$result = upsertArticles($pdo, $articles, '__CATEGORY__', [
    'enqueue_newsletter' => __ENQUEUE__,
    'regenerate_pdf' => true,
    'log_prefix' => $__articleLogPrefix,
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

$total = count($articles);
PHP;
    $newBlock = str_replace(['__CATEGORY__', '__ENQUEUE__'], [$category, $enqueueNewsletter], $newBlock);

    $content = preg_replace($pattern, $newBlock, $content, 1);

    // Pridaj require article_publisher.php ak ešte nie je.
    if (!str_contains($content, 'article_publisher.php')) {
        $requireLine = "require_once __DIR__ . '/article_publisher.php';";
        // Vložíme za require db_config.php, ak existuje.
        if (preg_match("/require_once __DIR__ . '\/db_config\.php';/", $content)) {
            $content = preg_replace(
                "/(require_once __DIR__ . '\/db_config\.php';)/",
                "$1\n" . $requireLine,
                $content,
                1
            );
        } else {
            // Fallback: pridaj na začiatok po <?php
            $content = preg_replace('/(<\?php\s*)/', "<?php\n" . $requireLine . "\n", $content, 1);
        }
    }

    file_put_contents($file, $content);
    $convertedFiles[] = basename($file) . ' (' . $category . ', enqueue=' . $enqueueNewsletter . ')';
}

echo "Konvertované " . count($convertedFiles) . " súborov:\n";
foreach ($convertedFiles as $f) {
    echo "  - $f\n";
}
echo "\nPreskočené " . count($skippedFiles) . " súborov:\n";
foreach ($skippedFiles as $f) {
    echo "  - $f\n";
}
