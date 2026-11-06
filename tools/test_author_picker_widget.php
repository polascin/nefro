<?php

declare(strict_types=1);

/**
 * Widget „Zúčastnení autori": <datalist> všetkých zdrojových autorov (~2 600
 * mien, ~200 kB HTML) sa vykresľuje len na index.php. Stránka článku dostane
 * odkaz na výber na index.php?autori=1, ktorý <details> otvorí.
 *
 * Bez DB: pomocné funkcie z db_config.php sú nahradené jednoduchými stubmi.
 */

$checks = 0;
function authorPickerTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

if (!function_exists('splitParticipatingAuthors')) {
    /**
     * @param array<int,array{author:string,articles:int}> $authors
     * @return array{project:array<int,array{author:string,articles:int}>,sources:array<int,array{author:string,articles:int}>,total:int}
     */
    function splitParticipatingAuthors(array $authors): array
    {
        return ['project' => [], 'sources' => $authors, 'total' => count($authors)];
    }
}
if (!function_exists('formatProjectArticleCountLabel')) {
    function formatProjectArticleCountLabel(int $count): string
    {
        return $count . ' čl.';
    }
}
if (!function_exists('formatParticipatingAuthorsLabel')) {
    function formatParticipatingAuthorsLabel(int $count): string
    {
        return $count . ' autorov';
    }
}

/**
 * @param array<string, mixed> $vars
 */
function renderAuthorWidget(array $vars): string
{
    extract($vars);
    ob_start();
    include dirname(__DIR__) . '/widget_participating_authors.php';

    return (string) ob_get_clean();
}

$authors = [];
for ($i = 1; $i <= 20; $i++) {
    $authors[] = ['author' => 'Autor Testovací ' . $i, 'articles' => 1];
}

$index = renderAuthorWidget(['projectAuthors' => $authors, 'authorFilterBase' => '']);
authorPickerTest(str_contains($index, '<datalist id="source-author-options">'), 'Index vykreslí datalist autorov.');
authorPickerTest(substr_count($index, '<option value=') === 20, 'Datalist obsahuje všetkých 20 zdrojových autorov.');
authorPickerTest(str_contains($index, 'id="autori-vyhladanie"') && !str_contains($index, 'id="autori-vyhladanie" open'), 'Index: výber je predvolene zatvorený.');

$indexOpen = renderAuthorWidget(['projectAuthors' => $authors, 'authorFilterBase' => '', 'authorPickerOpen' => true]);
authorPickerTest(str_contains($indexOpen, 'id="autori-vyhladanie" open'), 'index.php?autori=1 výber otvorí.');

$article = renderAuthorWidget(['projectAuthors' => $authors, 'authorFilterBase' => 'index.php', 'authorPickerInline' => false]);
authorPickerTest(!str_contains($article, '<datalist'), 'Stránka článku nevykresľuje datalist.');
authorPickerTest(str_contains($article, 'href="index.php?autori=1#autori-vyhladanie"'), 'Stránka článku odkazuje na výber na index.php.');
authorPickerTest(substr_count($article, 'class="author-filter-link"') === 8, 'Stránka článku ukazuje 8 najčastejších autorov.');

$root = dirname(__DIR__);
$articleSrc = (string) file_get_contents($root . '/article.php');
$indexSrc = (string) file_get_contents($root . '/index.php');
authorPickerTest(str_contains($articleSrc, '$authorPickerInline = false;'), 'article.php vypína inline výber autora.');
authorPickerTest(str_contains($indexSrc, "requestScalarString(\$_GET, 'autori', '') === '1'"), 'index.php otvára výber cez ?autori=1.');

echo "Author picker widget: $checks PASS\n";
