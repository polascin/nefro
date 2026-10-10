<?php

declare(strict_types=1);
/**
 * Verejné sťahovanie bezplatných publikácií.
 *
 * Priečinok /pdf je zámerne neprístupný priamo, preto tento endpoint povoľuje
 * iba presne určené vydania a formáty. Neotvára prístup k PDF článkov.
 *
 * Použitie: download_free_publication.php?edition=sk&format=pdf
 */

require_once __DIR__ . '/auth.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
    http_response_code(405);
    header('Allow: GET');
    header('Content-Type: text/plain; charset=utf-8');
    header('Cache-Control: no-store');
    exit("Táto metóda sťahovania nie je podporovaná.\n");
}

$edition = trim((string) ($_GET['edition'] ?? ''));
$format = trim((string) ($_GET['format'] ?? ''));

$publications = [
    'sk' => [
        'stem' => 'sk-nefro-dokazane-pravdepodobne-otvorene',
        'download_stem' => 'SK-Nefro-Dokazane-pravdepodobne-otvorene',
    ],
    'en' => [
        'stem' => 'sk-nefro-proven-probable-open',
        'download_stem' => 'SK-Nefro-Proven-Probable-Open',
    ],
    'de' => [
        'stem' => 'sk-nefro-belegt-wahrscheinlich-offen',
        'download_stem' => 'SK-Nefro-Belegt-wahrscheinlich-offen',
    ],
];

$mimeTypes = [
    'pdf' => 'application/pdf',
    'epub' => 'application/epub+zip',
    'azw3' => 'application/vnd.amazon.ebook',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'odt' => 'application/vnd.oasis.opendocument.text',
];

if (!isset($publications[$edition], $mimeTypes[$format])) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    header('Cache-Control: no-store');
    exit('Publikácia alebo formát sa nenašli.');
}

$publication = $publications[$edition];
$fileName = $publication['stem'] . '.' . $format;
$path = __DIR__ . '/pdf/publikacie/' . $fileName;

if (!is_file($path) || !is_readable($path)) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    header('Cache-Control: no-store');
    exit('Súbor sa nenašiel.');
}

while (ob_get_level() > 0) {
    ob_end_clean();
}

$downloadName = $publication['download_stem'] . '.' . $format;
header('Content-Type: ' . $mimeTypes[$format]);
header('Content-Disposition: attachment; filename="' . $downloadName . '"');
header('Content-Length: ' . filesize($path));
header('X-Content-Type-Options: nosniff');
header('Cache-Control: public, max-age=86400');

readfile($path);
exit;
