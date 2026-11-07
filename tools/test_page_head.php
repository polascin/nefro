<?php

declare(strict_types=1);

/**
 * Každá stránka, ktorá vkladá hlavičku webu (header.php), musí mať vlastný
 * <!DOCTYPE>/<head> alebo spoločný head (head_meta.php, legal_head.php).
 *
 * Dôvod (Beh 170): content_report.php (kontaktné miesto DSA) a
 * admin_content_notices.php vkladali len header.php, takže chýbal DOCTYPE,
 * <title>, CSS aj canonical a prehliadač ich vykresľoval v quirks móde.
 */

$checks = 0;
function pageHeadTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

$root = dirname(__DIR__);
$pages = 0;
foreach (glob($root . '/*.php') ?: [] as $file) {
    $src = (string) file_get_contents($file);
    if (preg_match('~(?:include|require)(?:_once)?\s*\(?\s*(?:__DIR__\s*\.\s*)?["\']/?header\.php["\']~', $src) !== 1) {
        continue;
    }
    ++$pages;
    $hasHead = str_contains($src, '<!DOCTYPE')
        || preg_match('~["\']/?(?:head_meta|legal_head)\.php["\']~', $src) === 1;
    pageHeadTest($hasHead, basename($file) . ' vkladá header.php bez <!DOCTYPE>/<head> (head_meta.php alebo legal_head.php).');
}
pageHeadTest($pages >= 40, "Príliš málo stránok s header.php ({$pages}); heuristika zlyhala.");

// Jediný <h1> (Beh 187): hlavička dáva názov portálu ako <h1> len stránkam bez
// vlastného nadpisu; stránka s vlastným <h1> musí nastaviť $pageHasOwnH1 = true.
$header = (string) file_get_contents($root . '/header.php');
pageHeadTest(str_contains($header, "\$siteHeaderTitleTag = !empty(\$pageHasOwnH1) ? 'p' : 'h1';"), 'header.php volí tag názvu portálu podľa $pageHasOwnH1.');
foreach (glob($root . '/*.php') ?: [] as $file) {
    $name = basename($file);
    if ($name === 'header.php' || str_starts_with($name, 'add_') || in_array($name, ['auth.php', 'pdf_generator.php', 'refresh_article.php', 'admin_users_notice.php'], true)) {
        continue;
    }
    $src = (string) file_get_contents($file);
    if (preg_match('~<h1\b~', $src) !== 1 || preg_match('~["\']/?(?:header|legal_head)\.php["\']~', $src) !== 1) {
        continue;
    }
    pageHeadTest(str_contains($src, '$pageHasOwnH1 = true;'), "{$name} má vlastný <h1>, musí nastaviť \$pageHasOwnH1 = true (inak dva <h1>).");
}
$articleSrc = (string) file_get_contents($root . '/article.php');
pageHeadTest(str_contains($articleSrc, '<h1 class="page-title" itemprop="headline">'), 'Titulok článku je <h1 class="page-title">.');

$report = (string) file_get_contents($root . '/content_report.php');
pageHeadTest(str_contains($report, "\$legalSlug        = 'content_report.php';"), 'content_report.php má canonical cez legal_head.php.');

echo "Page head: $checks PASS\n";
