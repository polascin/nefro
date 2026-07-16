<?php

declare(strict_types=1);
require_once __DIR__ . '/auth.php';

// Vyžadujeme POST s platným CSRF tokenom, aby sa zabránilo force-logout CSRF útoku.
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit;
}
if (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
    http_response_code(403);
    exit;
}

clearUserSession();

// Presmerovanie na hlavnú stránku
header("Location: index.php", true, 303);
exit;
?>
