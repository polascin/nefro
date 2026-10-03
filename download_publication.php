<?php

declare(strict_types=1);
/**
 * download_publication.php
 * ────────────────────────────────────────────────────────────────────────────
 * Servíruje súbory kúpenej publikácie. Súbory ležia v `private/publications/`,
 * ktorý .htaccess blokuje — jediná cesta k nim vedie cez tento skript, ktorý
 * overí zaplatenú objednávku podľa variabilného symbolu a prístupového tokenu.
 *
 * Použitie: download_publication.php?vs=<VS>&t=<token>&format=<pdf|epub|…>
 *
 * Prihlásenie sa nevyžaduje — kupujúci nemusí mať účet. Oprávnenie nesie
 * samotný token (odvodený HMAC-om zo soli v DB); strop PUBLICATION_DOWNLOAD_MAX
 * ohraničuje škodu, ak by kupujúci odkaz predsa len niekomu poslal.
 * ────────────────────────────────────────────────────────────────────────────
 */

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/publications_common.php';

/** Odpoveď v čistom texte — na binárnom endpointe nemá zmysel renderovať HTML. */
function publicationDownloadFail(int $code, string $message): never
{
    http_response_code($code);
    header('Content-Type: text/plain; charset=utf-8');
    header('Cache-Control: no-store');
    exit($message . "\n");
}

$variableSymbol = trim((string) ($_GET['vs'] ?? ''));
$token          = trim((string) ($_GET['t'] ?? ''));
$formatCode     = strtolower(trim((string) ($_GET['format'] ?? '')));

if ($variableSymbol === '' || $token === '' || $formatCode === '') {
    publicationDownloadFail(400, 'Neúplný odkaz na stiahnutie.');
}

// Rate limit podľa IP. Chráni dvojmo: proti hádaniu tokenov a proti tomu, aby
// jeden zdieľaný odkaz ťahal desiatky 20–28 MB súborov v cykle.
try {
    if (!checkFormRateLimit($pdo, 'publication_download', getClientIpAddress(), 60, 3600)) {
        http_response_code(429);
        header('Retry-After: 3600');
        header('Content-Type: text/plain; charset=utf-8');
        header('Cache-Control: no-store');
        exit("429 — Prekročený limit sťahovania.\n\nSkúste to prosím neskôr.\n");
    }

    $order = findPublicationOrderByToken($pdo, $variableSymbol, $token);
} catch (\PDOException $e) {
    error_log('download_publication.php: dotaz na objednávku zlyhal: ' . $e->getMessage());
    publicationDownloadFail(503, 'Služba je momentálne nedostupná. Skúste to prosím o chvíľu znova.');
}

if ($order === null) {
    publicationDownloadFail(404, 'Objednávka sa nenašla alebo odkaz nie je platný.');
}

if (!in_array($formatCode, publicationOrderFormats($order), true)) {
    publicationDownloadFail(403, 'Tento formát nie je súčasťou vašej objednávky.');
}

if ((string) $order['status'] !== 'paid') {
    publicationDownloadFail(
        402,
        'Objednávka ešte nie je zaplatená. Platobné pokyny nájdete na stránke objednávky: '
        . publicationOrderUrl($variableSymbol, $token)
    );
}

if (!publicationOrderIsDownloadable($order)) {
    publicationDownloadFail(
        403,
        'Prístup na stiahnutie už nie je aktívny (uplynula platnosť alebo bol vyčerpaný '
        . 'limit stiahnutí). Napíšte nám na ' . publicationSeller()['email']
        . ' s variabilným symbolom ' . $variableSymbol . ' a prístup obnovíme.'
    );
}

$slug = (string) $order['publication_slug'];
$path = publicationFilePath($slug, $formatCode);
if ($path === null) {
    error_log('download_publication.php: chýba súbor ' . $slug . '.' . $formatCode
        . ' pre objednávku ' . $variableSymbol);
    publicationDownloadFail(404, 'Súbor nie je momentálne k dispozícii. Napíšte nám prosím na '
        . publicationSeller()['email'] . '.');
}

recordPublicationDownload($pdo, (int) $order['id'], $formatCode);

$formats  = publicationFormats();
$ext      = (string) $formats[$formatCode]['ext'];
$mimeType = (string) $formats[$formatCode]['mime'];

// Čitateľný názov odvodíme z titulu objednávky; súbor na disku je ASCII.
$downloadName  = (string) $order['publication_title'] . '.' . $ext;
$asciiFallback = publicationAsciiFilename($downloadName);

// Vyčisti prípadný buffer, aby sme neporušili binárny výstup.
while (ob_get_level() > 0) {
    ob_end_clean();
}

header('Content-Type: ' . $mimeType);
header('Content-Disposition: attachment; '
    . 'filename="' . $asciiFallback . '"; '
    . "filename*=UTF-8''" . rawurlencode($downloadName));
header('Content-Length: ' . (string) filesize($path));
header('X-Content-Type-Options: nosniff');
header('Cache-Control: private, no-store, max-age=0, must-revalidate');

readfile($path);
exit;
