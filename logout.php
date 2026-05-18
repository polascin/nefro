<?php
require_once 'auth.php';

// Vyžadujeme POST s platným CSRF tokenom, aby sa zabránilo force-logout CSRF útoku.
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST' || !validateCsrfToken($_POST['csrf_token'] ?? '')) {
    header("Location: index.php");
    exit;
}

clearUserSession();

// Presmerovanie na hlavnú stránku
header("Location: index.php");
exit;
?>
