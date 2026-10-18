<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli-server' || !is_file('/.dockerenv')) {
    http_response_code(403);
    exit('Restore router requires the isolated built-in server.');
}

// Explicit endpoints on container loopback, without static fallback.
$path = parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
$allowed = ['/download_free_publication.php', '/index.php', '/article.php', '/search.php', '/login.php', '/download_pdf.php'];
if (!in_array($path, $allowed, true)) {
    http_response_code(403);
    exit('Restore route denied.');
}
$appRoot = realpath('/restore');
if ($appRoot === false) {
    http_response_code(503);
    exit('Restore root missing.');
}
require $appRoot . $path;
