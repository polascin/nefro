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

$report = (string) file_get_contents($root . '/content_report.php');
pageHeadTest(str_contains($report, "\$legalSlug        = 'content_report.php';"), 'content_report.php má canonical cez legal_head.php.');

echo "Page head: $checks PASS\n";
