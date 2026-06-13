<?php
declare(strict_types=1);
/**
 * download_pdf.php
 * ────────────────────────────────────────────────────────────────────────────
 * Bezpečné servírovanie PDF verzií článkov. Bonus dostupný IBA pre
 * registrovaných a prihlásených používateľov. Priečinok /pdf je cez .htaccess
 * zakázaný pre priamy prístup; jediná cesta k súboru vedie cez tento skript.
 *
 * Použitie:  download_pdf.php?slug=<slug-clanku>
 * ────────────────────────────────────────────────────────────────────────────
 */

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';

// Iba prihlásení (registrovaní) používatelia
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Validácia slugu (len písmená, číslice, pomlčky)
$slug = trim((string) ($_GET['slug'] ?? ''));
if ($slug === '' || !preg_match('/^[a-z0-9-]{1,120}$/', $slug)) {
    http_response_code(400);
    header('Content-Type: text/plain; charset=utf-8');
    exit('Neplatný článok.');
}

// Načítaj PDF priradené k zverejnenému článku
$stmt = $pdo->prepare(
    "SELECT pdf_file FROM articles WHERE slug = :slug AND is_published = 1 LIMIT 1"
);
$stmt->execute(['slug' => $slug]);
$row = $stmt->fetch();

$pdfName = $row ? trim((string) ($row['pdf_file'] ?? '')) : '';
if ($pdfName === '') {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    exit('Pre tento článok nie je k dispozícii PDF.');
}

// Ochrana proti path traversal — povolíme len holý názov súboru v /pdf
$pdfName = basename($pdfName);
$path = __DIR__ . '/pdf/' . $pdfName;

if (substr($pdfName, -4) !== '.pdf' || !is_file($path) || !is_readable($path)) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    exit('Súbor sa nenašiel.');
}

// Vyčisti prípadný buffer, aby sme neporušili binárny výstup
while (ob_get_level() > 0) {
    ob_end_clean();
}

// Hlavičky na stiahnutie. RFC 5987 (filename*) pre diakritiku v názve.
$asciiFallback = preg_replace('/[^A-Za-z0-9._ -]/', '_', $pdfName);
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; '
    . 'filename="' . $asciiFallback . '"; '
    . "filename*=UTF-8''" . rawurlencode($pdfName));
header('Content-Length: ' . filesize($path));
header('X-Content-Type-Options: nosniff');
header('Cache-Control: private, max-age=0, must-revalidate');

readfile($path);
exit;
