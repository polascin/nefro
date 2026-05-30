<?php
declare(strict_types=1);
// Ochrana: súbor je určený iba pre CLI použitie
if (php_sapi_name() !== 'cli') { http_response_code(403); exit('Forbidden'); }

/**
 * CLI nástroj na validáciu dynamickej sitemapy.
 *
 * sitemap.php je plne dynamický súbor — URL zoznam generuje priamo z databázy
 * a zo súborových časových pečiatok (filemtime). Nie je potrebné upravovať zdrojový
 * kód sitemap.php. Tento skript overuje, že sitemap.php generuje platné XML.
 *
 * Použitie: php update_sitemap.php [--base-dir /cesta/k/projektu]
 */

$baseDir = __DIR__;
foreach ($argv as $i => $arg) {
    if ($arg === '--base-dir' && isset($argv[$i + 1])) {
        $baseDir = rtrim($argv[$i + 1], '/\\');
    }
}

$sitemapPath = $baseDir . DIRECTORY_SEPARATOR . 'sitemap.php';

if (!is_file($sitemapPath)) {
    fwrite(STDERR, "CHYBA: sitemap.php nenájdený v {$baseDir}\n");
    exit(1);
}

// Načítaj výstup sitemap.php cez output buffering (vyžaduje db_config.php a PDO)
$dbConfigPath = $baseDir . DIRECTORY_SEPARATOR . 'db_config.php';
if (!is_file($dbConfigPath)) {
    fwrite(STDERR, "CHYBA: db_config.php nenájdený — nie je možné načítať sitemapu.\n");
    exit(1);
}

ob_start();
try {
    // Simuluj web kontext pre sitemap.php
    $_SERVER['REQUEST_URI'] = '/sitemap.php';
    require $dbConfigPath;
    require $sitemapPath;
} catch (\Throwable $e) {
    ob_end_clean();
    fwrite(STDERR, "CHYBA pri generovaní sitemap.php: " . $e->getMessage() . "\n");
    exit(1);
}
$xml = ob_get_clean();

// Validuj XML
libxml_use_internal_errors(true);
$doc = simplexml_load_string($xml);
if ($doc === false) {
    fwrite(STDERR, "CHYBA: sitemap.php generuje neplatné XML:\n");
    foreach (libxml_get_errors() as $err) {
        fwrite(STDERR, "  [{$err->line}] " . trim($err->message) . "\n");
    }
    exit(1);
}

// Spočítaj URL záznamy
$urls = $doc->url ?? [];
$count = count($urls);

echo "OK: sitemap.php generuje platné XML s {$count} URL záznamy.\n";

// Vypíš prvých 5 URL pre kontrolu
echo "\nPrvých 5 URL:\n";
foreach (array_slice((array) $urls, 0, 5) as $url) {
    if (is_object($url)) {
        echo "  " . ($url->loc ?? '?') . "\n";
    }
}
if ($count > 5) {
    echo "  ... a ďalších " . ($count - 5) . " URL.\n";
}
echo "\nSitemap je aktuálna — nie je potrebná žiadna ďalšia akcia.\n";
