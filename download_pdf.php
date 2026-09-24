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
/** @var \PDO $pdo */

// Iba prihlásení (registrovaní) používatelia
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// PDF verzie článkov sú najlákavejší cieľ hromadného zberu — jeden účet by
// inak vedel stiahnuť celý archív za pár minút. Limit je nad rámec bežného
// používania (čitateľ si otvorí niekoľko článkov), ale zbieranie zastaví.
// Počíta sa podľa prihláseného účtu, nie podľa IP: pri zdieľanej IP
// (ambulancia, nemocnica) by IP limit trestal nezúčastnených.
const PDF_DOWNLOAD_WINDOW = 3600;
const PDF_DOWNLOAD_MAX    = 40;

$pdfRlKey = 'user:' . (int) ($_SESSION['user_id'] ?? 0);
$pdfNow   = time();
$pdfCount = 0;

botGuardMutateState($pdfRlKey, static function (array $s) use ($pdfNow, &$pdfCount): array {
    if (($pdfNow - (int) ($s['pdf_start'] ?? 0)) >= PDF_DOWNLOAD_WINDOW) {
        $s['pdf_start'] = $pdfNow;
        $s['pdf_count'] = 0;
    }
    $s['pdf_count'] = (int) ($s['pdf_count'] ?? 0) + 1;
    $pdfCount = (int) $s['pdf_count'];

    return $s;
});

if ($pdfCount > PDF_DOWNLOAD_MAX) {
    botGuardLog('throttle', 'pdf-download ' . $pdfCount . '/' . PDF_DOWNLOAD_MAX);
    http_response_code(429);
    header('Retry-After: ' . PDF_DOWNLOAD_WINDOW);
    header('Content-Type: text/plain; charset=utf-8');
    header('Cache-Control: no-store');
    exit(
        "429 — Prekročený limit sťahovania PDF.\n\n"
        . 'Z tohto účtu bolo za poslednú hodinu stiahnutých viac než '
        . PDF_DOWNLOAD_MAX . " PDF súborov.\n"
        . "Skúste to znova neskôr.\n"
    );
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
    "SELECT title, pdf_file FROM articles WHERE slug = :slug AND is_published = 1 LIMIT 1"
);
$stmt->execute(['slug' => $slug]);
$row = $stmt->fetch();

$pdfName = $row ? trim((string) ($row['pdf_file'] ?? '')) : '';
$title   = $row ? trim((string) ($row['title'] ?? '')) : '';
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

// Čitateľný názov pri sťahovaní odvodíme z titulu článku (súbor na disku je ASCII).
$downloadName = ($title !== '' ? $title : pathinfo($pdfName, PATHINFO_FILENAME)) . '.pdf';
// RFC 5987 (filename*) pre diakritiku; ASCII fallback pre staré prehliadače.
$asciiFallback = preg_replace('/[^A-Za-z0-9._ -]/', '_', $downloadName);
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; '
    . 'filename="' . $asciiFallback . '"; '
    . "filename*=UTF-8''" . rawurlencode($downloadName));
header('Content-Length: ' . filesize($path));
header('X-Content-Type-Options: nosniff');
header('Cache-Control: private, max-age=0, must-revalidate');

readfile($path);
exit;
